<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CustomFieldValue;
use Illuminate\Support\Facades\Storage;

class StudentFormController extends Controller
{
  private function saveCustomFields(Request $request, $category)
  {
    // 1. Ambil field yang relevan
    $customFields = CustomField::where('category', $category)->get();
    $userId = Auth::id();

    // Whitelist MIME yang diizinkan untuk custom fields
    $allowedMime = [
      'image/jpeg',
      'image/png',
      'application/pdf',
      'application/msword', // .doc
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
    ];

    foreach ($customFields as $field) {
      $inputName = 'custom_' . $field->id;

      // Skip jika tidak ada input
      if (!$request->has($inputName) && !$request->hasFile($inputName)) {
        continue;
      }

      $value = null;

      // 2. Keamanan Tipe File (Private Storage & Real MIME Check)
      if ($field->type == 'file' && $request->hasFile($inputName)) {
        $file = $request->file($inputName);

        if ($file->isValid()) {
          // Check MIME asli (Anti-Polyglot)
          $realMime = $file->getMimeType();

          if (in_array($realMime, $allowedMime)) {
            // Hapus file lama dari disk LOCAL sebelum ganti baru
            $oldValue = CustomFieldValue::where('user_id', $userId)
              ->where('custom_field_id', $field->id)
              ->first();

            if ($oldValue && $oldValue->value) {
              Storage::disk('local')->delete($oldValue->value);
            }

            // SIMPAN DI STORAGE LOCAL (PRIVATE)
            // Menggunakan hashName bawaan agar nama file acak & aman
            $value = $file->store('documents', 'local');
          }
        }
      }
      // 3. Keamanan Tipe Teks (Sanitasi XSS)
      else {
        $rawValue = $request->input($inputName);

        // strip_tags menghapus <script>, <html>, dll. 
        // trim menghapus spasi kosong yang tidak perlu
        $value = is_string($rawValue) ? trim(strip_tags($rawValue)) : $rawValue;
      }

      // 4. Update atau Simpan ke Database
      if ($value !== null) {
        CustomFieldValue::updateOrCreate(
          ['user_id' => $userId, 'custom_field_id' => $field->id],
          ['value' => $value]
        );
      }
    }
  }

  public function viewCustomField(CustomField $field)
  {
    $user = Auth::user();

    abort_unless($field->type === 'file', 404);

    $value = CustomFieldValue::where('user_id', $user->id)
      ->where('custom_field_id', $field->id)
      ->first();

    if (!$value || !$value->value) {
      abort(404);
    }

    $path = $value->value;

    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->file(
      storage_path('app/' . $path),
      [
        'Content-Type' => $value->mime ?? 'application/octet-stream',
        'Content-Disposition' => 'inline'
      ]
    );
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $user = auth()->user()->load([
      'identity',
      'registration.studentDetails',
      'registration.studentProfile',
      'registration.studentFamily',
      'validity'
    ]);

    $isLocked = $user->validity?->is_data_valid == 1;

    $studyPrograms = StudyProgram::where('is_active', true)->select('id', 'name', 'faculty')->get();
    $customFields = CustomField::where('category', 'registration')->orderBy('order')->get();

    return view('camaba.form.index', compact(
      'user',
      'customFields',
      'studyPrograms',
      'isLocked'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      // Identity & Registration
      'full_name'   => 'required|string|max:255',
      'nik_identity' => 'required|digits:16',
      'birth_place' => 'required|string',
      'birth_date'  => 'required|date',
      'gender'      => 'required|in:L,P',
      'entry_path'  => 'required',
      'study_program' => 'required',

      'kewarganegaraan' => 'required|string',
      'nisn'            => 'required|digits:10',
      'hp'              => 'required|numeric',
      'email'           => 'required|email',
      'kelurahan'       => 'required',
      'kecamatan'       => 'required',

      'nama_ayah'       => 'required|string',
      'nama_ibu'        => 'required|string',
      'nik_ayah'        => 'nullable|digits:16',
      'nik_ibu'         => 'nullable|digits:16',
    ], [
      'nik_identity.digits' => 'NIK Mahasiswa harus 16 digit.',
      'nisn.digits'         => 'NISN harus berjumlah 10 digit.',
      'hp.required'         => 'Nomor HP wajib diisi.',
    ]);

    DB::transaction(function () use ($request, $user) {
      // A. Update Identity
      $user->identity()->updateOrCreate(['user_id' => $user->id], [
        'full_name'   => $request->full_name,
        'nik'         => $request->nik_identity,
        'birth_place' => $request->birth_place,
        'birth_date'  => $request->birth_date,
        'gender'      => $request->gender,
      ]);

      // B. Update Registration
      $registration = $user->registration()->updateOrCreate(['user_id' => $user->id], [
        'entry_path'         => $request->entry_path,
        'participant_number' => $request->participant_number,
        'school_origin'      => $request->school_origin,
        'graduation_year'    => $request->graduation_year,
        'study_program_id'   => $request->study_program,
      ]);

      // C. Update Student Profile (NISN, Religion, dll)
      $registration->studentProfile()->updateOrCreate(['registration_id' => $registration->id], [
        'nisn'           => $request->nisn,
        'religion'       => $request->religion, // pastikan ada di input
        'nama_pondok'    => $request->nama_pondok,
        'alamat_pondok'  => $request->alamat_pondok,
      ]);

      // D. Update Student Details (Alamat & Kebutuhan Khusus Mahasiswa)
      $registration->studentDetails()->updateOrCreate(['registration_id' => $registration->id], [
        'kewarganegaraan'            => $request->kewarganegaraan,
        'npwp'                       => $request->npwp,
        'jalan'                      => $request->jalan,
        'dusun'                      => $request->dusun,
        'rt'                         => $request->rt,
        'rw'                         => $request->rw,
        'kelurahan'                  => $request->kelurahan,
        'kecamatan'                  => $request->kecamatan,
        'kode_pos'                   => $request->kode_pos,
        'telepon'                    => $request->telephone,
        'hp'                         => $request->hp,
        'email'                      => $request->email,
        'penerima_kps'               => $request->penerima_kps,
        'alat_transportasi'          => $request->alat_transportasi,
        'jenis_tinggal'              => $request->jenis_tinggal,
        'kebutuhan_khusus_mahasiswa' => $request->kebutuhan_khusus_mahasiswa,
        // Sesuai model StudentDetails yang kamu upload:
        'kebutuhan_khusus_ayah'      => $request->kebutuhan_khusus_ayah,
        'kebutuhan_khusus_ibu'       => $request->kebutuhan_khusus_ibu,
      ]);

      // E. Update Student Family (Data Detail Orang Tua)
      $registration->studentFamily()->updateOrCreate(['registration_id' => $registration->id], [
        'nik_ayah'         => $request->nik_ayah,
        'nama_ayah'        => $request->nama_ayah,
        'tgl_lahir_ayah'   => $request->tgl_lahir_ayah,
        'pendidikan_ayah'  => $request->pendidikan_ayah,
        'pekerjaan_ayah'   => $request->pekerjaan_ayah,
        'penghasilan_ayah' => $request->penghasilan_ayah,
        'nik_ibu'          => $request->nik_ibu,
        'nama_ibu'         => $request->nama_ibu,
        'tgl_lahir_ibu'    => $request->tgl_lahir_ibu,
        'pendidikan_ibu'   => $request->pendidikan_ibu,
        'pekerjaan_ibu'    => $request->pekerjaan_ibu,
        'penghasilan_ibu'  => $request->penghasilan_ibu,
      ]);

      // F. Custom Fields (Jika ada tambahan field dinamis)
      $this->saveCustomFields($request, 'registration');
    });

    return redirect()->route('isi-dokumen')->with('success', 'Seluruh data mahasiswa berhasil disimpan!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
