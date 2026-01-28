<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentFormController extends Controller
{
  //
  public function show(int $id)
  {
    $user = User::with([
      'identity',
      'registration',
      'registration.studentDetails',
      'registration.studentProfile',
      'registration.studentFamily',
      'validity',
    ])->findOrFail($id);

    $isLocked = false;

    $studyPrograms = StudyProgram::query()
      ->where('is_active', true)
      ->select('id', 'name', 'faculty')
      ->get();

    $customFields = CustomField::query()
      ->where('category', 'registration')
      ->orderBy('order')
      ->get();

    return view('admin.pendaftar.form.show', compact(
      'user',
      'customFields',
      'studyPrograms',
      'isLocked'
    ));
  }


  public function store(Request $request, $id)
  {
    $user = User::findOrFail($id);

    // Validasi dasar (tambahkan yang sekiranya wajib diisi)
    $request->validate([
      'full_name' => 'required|string|max:255',
    ]);

    // dd($request->all());

    return DB::transaction(function () use ($request, $user) {

      // 1. UPDATE TABEL IDENTITIES (NIK Random handling)
      $finalNIK = $request->nik_identity;
      $isUsed = \App\Models\Identity::where('nik', $finalNIK)->where('user_id', '!=', $user->id)->exists();
      if (!$finalNIK || $isUsed) {
        $finalNIK = '10' . mt_rand(10000000000000, 99999999999999);
      }

      $user->identity()->updateOrCreate(['user_id' => $user->id], [
        'full_name'   => $request->full_name ?? $user->name,
        'nik'         => $finalNIK,
        'birth_place' => $request->birth_place ?? 'Default City',
        'birth_date'  => $request->birth_date ?? '2000-01-01',
        'gender'      => $request->gender ?? 'L',
      ]);

      // 2. UPDATE TABEL REGISTRATIONS
      $registration = $user->registration()->updateOrCreate(['user_id' => $user->id], [
        'entry_path'         => $request->entry_path ?? 'MANDIRI',
        'participant_number' => $request->participant_number ?? ('REG-' . date('Y') . mt_rand(1000, 9999)),
        'school_origin'      => $request->school_origin ?? 'SMA DEFAULT',
        'graduation_year'    => $request->graduation_year ?? date('Y'),
        'study_program_id'   => $request->study_program ?? 1,
        'study_program_id_second' => $request->study_program_second ?? 1,
        'nim'                => $request->nim,
      ]);

      // 3. UPDATE TABEL STUDENT_DETAILS (Tab Alamat)
      $registration->studentDetails()->updateOrCreate(['registration_id' => $registration->id], [
        'nisn'           => $request->nisn ?? '0000000000',
        'jalan'         => $request->jalan ?? '-',
        'kewarganegaraan' => $request->kewarganegaraan ?? 'Indonesia',
        'email'          => $request->email ?? 'belumdiisi@gmail.com',
        'rt'             => $request->rt ?? '00',
        'rw'             => $request->rw ?? '00',
        'no'             => $request->no ?? '000',
        'hp'              => $request->hp ?? '081234567890',
        'telepon'          => $request->telephone ?? '08111111111',
        'dusun'          => $request->dusun ?? '-',
        'kelurahan_desa' => $request->kelurahan_desa ?? '-',
        'kecamatan'      => $request->kecamatan ?? '-',
        'kabupaten_kota' => $request->kabupaten_kota ?? '-',
        'provinsi'       => $request->provinsi ?? '-',
        'kode_pos'    => $request->kode_pos ?? '00000',
        'alat_transportasi' => $request->alat_transportasi ?? 'Jalan Kaki',
        'jenis_tinggal' => $request->jenis_tinggal ?? 'Jalan Kaki',
      ]);

      // 4. UPDATE TABEL STUDENT_PROFILES (Tab Khusus/Pribadi)
      $registration->studentProfile()->updateOrCreate(['registration_id' => $registration->id], [
        'religion'       => $request->religion ?? 'Islam',
        'stay_with'      => $request->stay_with ?? 'Orang Tua',
        'is_kps'         => $request->has('is_kps') ? true : false,
        'kps_number'     => $request->kps_number,
      ]);

      // 5. UPDATE TABEL STUDENT_FAMILIES (Tab Ortu)
      $registration->studentFamily()->updateOrCreate(['registration_id' => $registration->id], [
        // Data Ayah
        'father_name'       => $request->father_name ?? 'N/A',
        'father_birth_year' => $request->father_birth_year,
        'father_education'  => $request->father_education,
        'father_occupation' => $request->father_occupation,
        'father_income'     => $request->father_income,
        // Data Ibu
        'mother_name'       => $request->mother_name ?? 'N/A',
        'mother_birth_year' => $request->mother_birth_year,
        'mother_education'  => $request->mother_education,
        'mother_occupation' => $request->mother_occupation,
        'mother_income'     => $request->mother_income,
      ]);

      // 6. CUSTOM FIELDS
      if (method_exists($this, 'saveCustomFields')) {
        $this->saveCustomFields($request, 'registration');
      }

      return redirect()->route('admin.pendaftar.edit.show', $user->id)
        ->with('success', 'Semua data pendaftar (Alamat, Ortu, & Khusus) berhasil diperbarui!');
    });
  }
}
