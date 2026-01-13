<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;
use App\Models\CustomField; // Tambahkan ini
use App\Models\CustomFieldValue; // Tambahkan ini
use Illuminate\Support\Facades\Storage;
use App\Models\StudyProgram;

class FormController extends Controller
{

  public function createIdentity()
  {
    $user = Auth::user()->load(['identity', 'registration', 'customFieldValues']);



    // TWEAK: Ambil data jurusan yang aktif

    $isLocked = ($user->payment || $user->status == 'valid');

    $studyPrograms = StudyProgram::where('is_active', true)->get();

    // Ambil custom fields kategori registration
    $customFields = CustomField::where('category', 'registration')->orderBy('order')->get();

    return view('camaba.formulir.create', [
      'user' => $user,
      'customFields' => $customFields,
      'studyPrograms' => $studyPrograms, // Tambahkan ini
      'isLocked' => $isLocked
    ]);
  }

  // 2. Tampilan Upload Dokumen
  public function createDocuments()
  {
    $user = Auth::user()->load('document');
    $isLocked = ($user->document) ? true : false;

    // Ambil custom fields kategori document
    $customFields = CustomField::where('category', 'document')->orderBy('order')->get();

    return view('camaba.formulir.dokumen', [
      'user' => $user,
      'isLocked' => $isLocked,
      'customFields' => $customFields
    ]);
  }
  // Fungsi pembantu (helper) untuk menyimpan custom fields
  private function saveCustomFields(Request $request, $category)
  {
    $customFields = CustomField::where('category', $category)->get();
    foreach ($customFields as $field) {
      $inputName = 'custom_' . $field->id;

      if ($request->has($inputName) || $request->hasFile($inputName)) {
        $value = $request->input($inputName);

        // Jika tipe datanya adalah file, simpan filenya
        if ($field->type == 'file' && $request->hasFile($inputName)) {
          $value = $request->file($inputName)->store('custom_docs', 'public');
        }

        CustomFieldValue::updateOrCreate(
          ['user_id' => Auth::id(), 'custom_field_id' => $field->id],
          ['value' => $value ?? '']
        );
      }
    }
  }

  public function storeIdentity(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'full_name'   => 'required|string|max:255',
      // Validasi Unique: tabel 'identities', kolom 'nik', kecualikan ID user saat ini
      'nik_identity' => [
        'required',
        'digits:16',
        'unique:identities,nik,' . $user->id . ',user_id'
      ],
      'birth_place' => 'required|string',
      'birth_date'  => 'required|date',
      'gender'      => 'required|in:L,P',
      'entry_path'      => 'required',
      // Jika nomor peserta juga harus unik (opsional)
      'participant_number' => [
        'nullable',
        'unique:registrations,participant_number,' . $user->id . ',user_id'
      ],
      'school_origin'   => 'required',
      'graduation_year' => 'required|numeric',
      'study_program'   => 'required',
    ], [
      // Pesan kustom agar user paham
      'nik_identity.unique' => 'NIK ini sudah terdaftar. Silakan hubungi admin jika ini adalah NIK Anda.',
      'participant_number.unique' => 'Nomor peserta ini sudah digunakan oleh pendaftar lain.',
      'nik_identity.digits' => 'NIK harus berjumlah 16 digit.',
    ]);

    DB::transaction(function () use ($request, $user) {
      $user->identity()->updateOrCreate(['user_id' => $user->id], [
        'full_name'   => $request->full_name,
        'nik'         => $request->nik_identity,
        'birth_place' => $request->birth_place,
        'birth_date'  => $request->birth_date,
        'gender'      => $request->gender,
      ]);

      $user->registration()->updateOrCreate(['user_id' => $user->id], [
        'entry_path'         => $request->entry_path,
        'participant_number' => $request->participant_number,
        'school_origin'      => $request->school_origin,
        'graduation_year'    => $request->graduation_year,
        'study_program_id'   => $request->study_program,
      ]);

      $this->saveCustomFields($request, 'registration');
    });

    return redirect()->route('isi-dokumen')->with('success', 'Data identitas berhasil disimpan!');
  }

  public function storeDocuments(Request $request)
  {
    $user = Auth::user();

    if ($user->document) {
      return redirect()->back()->with('error', 'Dokumen sudah dikunci.');
    }

    $request->validate([
      'photo_formal' => 'nullable|image|max:2048',
      'ktp_scan'     => 'nullable|image|max:2048',
      'kk_scan'      => 'nullable|image|max:2048',
      'ijazah_scan'  => 'nullable|image|max:2048',
      'report_scan'  => 'nullable|mimes:pdf,jpg,png|max:5120',
    ]);

    $docFiles = ['photo_formal', 'ktp_scan', 'kk_scan', 'ijazah_scan', 'report_scan', 'achievement_certificate'];
    $docData = [];

    foreach ($docFiles as $file) {
      if ($request->hasFile($file)) {
        $docData[$file] = $request->file($file)->store('documents', 'public');
      }
    }

    DB::transaction(function () use ($user, $docData, $request) {
      $user->document()->updateOrCreate(['user_id' => $user->id], $docData);

      // TWEAK: Simpan Custom Fields Kategori Document (termasuk jika ada upload file custom)
      $this->saveCustomFields($request, 'document');
    });

    return redirect()->route('formulir.pembayaran')->with('success', 'Dokumen berhasil diunggah!');
  }

  public function storePayment(Request $request)
  {
    $request->validate([
      'account_name' => 'required|string|max:255',
      'proof_file'   => 'required|image|max:2048',
    ]);

    $user = Auth::user();
    $activeWave = RegistrationPeriod::where('is_active', true)->first();

    if (!$activeWave) {
      return back()->with('error', 'Maaf, tidak ada gelombang aktif.');
    }

    DB::transaction(function () use ($request, $user, $activeWave) {
      $user->payment()->updateOrCreate(
        ['user_id' => $user->id],
        [
          'account_name' => $request->account_name,
          'proof_file'   => $request->file('proof_file')->store('payments', 'public'),
          'status'       => 'pending',
        ]
      );

      // TWEAK: Pastikan relasi ke registration_period_id tersimpan di user
      // Ini penting untuk filter Statistik Admisi per Gelombang
      $user->registration_period_id = $activeWave->id;
      $user->save();

      // Opsional: Jika di tabel registrations juga ada registration_period_id, update juga
      if ($user->registration) {
        $user->registration->update(['registration_period_id' => $activeWave->id]);
      }
    });

    return redirect()->route('formulir')->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
  }
}
