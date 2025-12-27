<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;

class FormController extends Controller
{
  // 1. Handle Halaman Isi Form (Identitas & Sekolah)
  public function storeIdentity(Request $request)
  {
    $request->validate([
      'full_name'   => 'required|string|max:255',
      'nik_identity' => 'required|digits:16',
      'birth_place' => 'required|string',
      'birth_date'  => 'required|date',
      'gender'      => 'required|in:L,P',
      'entry_path'      => 'required',
      'school_origin'   => 'required',
      'graduation_year' => 'required|numeric',
      'study_program'   => 'required',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

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
        'study_program'      => $request->study_program,
      ]);
    });

    return redirect()->route('isi-formulir')->with('success', 'Data identitas berhasil disimpan!');
  }

  // 2. Handle Halaman Upload Dokumen
  public function storeDocuments(Request $request)
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // CEK 1: Jika sudah punya data dokumen, cegah upload ulang (Proteksi Server-side)
    if ($user->document) {
      return redirect()->back()->with('error', 'Dokumen sudah diunggah dan tidak dapat diubah lagi.');
    }

    // CEK 2: Pastikan ada file yang diunggah (jangan sampai array kosong)
    if (!$request->hasAny(['photo_formal', 'ktp_scan', 'kk_scan', 'ijazah_scan', 'report_scan'])) {
      return redirect()->back()->with('error', 'Silakan pilih minimal satu dokumen wajib untuk diunggah.');
    }

    $request->validate([
      'photo_formal' => 'nullable|image|max:2048',
      'ktp_scan'     => 'nullable|image|max:2048',
      'kk_scan'      => 'nullable|image|max:2048', // Tambahkan ini
      'ijazah_scan'  => 'nullable|image|max:2048', // Tambahkan ini
      'report_scan'  => 'nullable|mimes:pdf,jpg,png|max:5120',
    ]);
    $docFiles = ['photo_formal', 'ktp_scan', 'kk_scan', 'ijazah_scan', 'report_scan', 'achievement_certificate'];
    $docData = [];

    foreach ($docFiles as $file) {
      if ($request->hasFile($file)) {
        $docData[$file] = $request->file($file)->store('documents', 'public');
      }
    }

    $user->document()->updateOrCreate(['user_id' => $user->id], $docData);

    return redirect()->route('formulir.pembayaran')->with('success', 'Dokumen berhasil diunggah!');
  }

  // 3. Handle Halaman Pembayaran
  public function storePayment(Request $request)
  {
    $request->validate([
      'account_name' => 'required|string|max:255',
      'proof_file'   => 'required|image|max:2048',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $activeWave = RegistrationPeriod::where('is_active', true)->first();

    if (!$activeWave) {
      return back()->with('error', 'Maaf, tidak ada gelombang aktif.');
    }

    // Gunakan Transaction agar data aman
    DB::transaction(function () use ($request, $user, $activeWave) {
      // 1. Simpan Payment
      $user->payment()->updateOrCreate(
        ['user_id' => $user->id],
        [
          'account_name' => $request->account_name,
          'proof_file'   => $request->file('proof_file')->store('payments', 'public'),
          'status'       => 'pending',
        ]
      );

      // 2. Update Gelombang di User
      $user->update([
        'registration_period_id' => $activeWave->id
      ]);
    });

    return redirect()->route('formulir')->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
  }
}
