<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CalonMahasiswaExport implements FromQuery, WithHeadings, WithMapping
{
  protected $type;
  protected $periodId;
  protected $rowNumber = 0;

  public function __construct($type, $periodId)
  {
    $this->type = $type;
    $this->periodId = $periodId;
  }

  public function query()
  {
    $query = User::query()
      ->with([
        'identity',
        'validity',
        'registration.studyProgram',
        'registration.studentDetails.province',
        'registration.studentDetails.city',
        'registration.studentDetails.district',
        'registration.studentProfile',
        'registration.studentFamily'
      ])
      ->whereNotIn('id', [1, 2]); // <-- taruh sini




    if (!empty($this->periodId) && $this->periodId !== 'all') {
      $query->where('registration_period_id', $this->periodId);
    }

    return match ($this->type) {
      'acc' => $query->whereHas(
        'validity',
        fn($q) =>
        $q->where('is_data_valid', 1)
      ),

      'pending_acc' => $query->whereHas(
        'validity',
        fn($q) =>
        $q->where('is_data_valid', 0)
      ),

      'cbt_done' => $query->whereHas(
        'examSession',
        fn($q) =>
        $q->where('status', 'done')
      ),

      'cbt_pending' => $query->whereDoesntHave(
        'examSession',
        fn($q) =>
        $q->where('status', 'done')
      ),

      'diterima' => $query->whereHas(
        'registration',
        fn($q) =>
        $q->where('status_kelulusan', 'lulus')
      ),

      'tidak_diterima' => $query->whereHas(
        'registration',
        fn($q) =>
        $q->where('status_kelulusan', 'tidak_lulus')
      ),

      default => $query,
    };
  }

  public function headings(): array
  {
    return [
      'No',
      'No. Pendaftaran',
      'Nama Lengkap',
      'NIK',
      'NISN',
      'NIM',
      'Email',
      'No. HP',
      'Program Studi',
      'Program Studi 2',
      'Diterima DI Prodi',
      'Gelombang',
      'Tempat Lahir',
      'Tanggal Lahir',
      'Jenis Kelamin',
      'Alamat (Jalan/Dusun)',
      'RT/RW',
      'Provinsi',
      'Kabupaten/Kota',
      'Kecamatan',
      'Kelurahan',
      'Asal Sekolah',
      'Tahun Lulus',
      'Nama Ayah',
      'Pekerjaan Ayah',
      'Nama Ibu',
      'Status Verifikasi',
      'Status Kelulusan'
    ];
  }

  public function map($user): array
  {
    $this->rowNumber++;
    $registration = $user->registration;
    $details = $registration?->studentDetails;
    $family = $registration?->studentFamily;


    return [
      $this->rowNumber,
      $registration->participant_number ?? '-',
      $user->identity?->full_name ?? $user->name ?? '-',
      "'" . ($user->identity?->nik ?? $user->nik ?? '-'), // Format String untuk Excel
      "'" . ($details?->nisn ?? '-'),
      "'" . ($registration?->nim ?? '-'),
      $user->email ?? "-",
      $registration->studentDetails?->hp ?? '-',
      $registration->studyProgram?->name ?? '-',
      $registration->secondStudyProgram?->name ?? '-',
      $registration->acceptedStudyProgram?->name ?? '-',
      $user->registrationPeriod?->name . " - " . ($user->registrationPeriod?->price === 0 ? "gratis" : ($user->registrationPeriod?->price ?? '-')),
      $user->identity?->birth_place ?? '-',
      $user->identity?->birth_date ?? '-',
      $user->identity?->gender == 'L' ? 'Laki-laki' : 'Perempuan',
      ($details?->jalan ?? '') . ' ' . ($details?->dusun ?? '-'),
      ($details?->rt ?? '0') . '/' . ($details?->rw ?? '0'),

      // Logika Wilayah: Cek Relasi ID dulu, jika null ambil kolom String
      $details?->province?->nm_wil ?? $details?->provinsi ?? '-',
      $details?->city?->nm_wil ?? $details?->kabupaten_kota ?? '-',
      $details?->district?->nm_wil ?? $details?->kecamatan ?? '-',

      $details?->kelurahan ?? '-',
      $registration->school_origin ?? '-',
      $registration->graduation_year ?? '-',
      $family?->nama_ayah ?? '-',
      $family?->pekerjaan_ayah ?? '-',
      $family?->nama_ibu ?? '-',
      ($user->validity?->is_data_valid == 1) ? 'Terverifikasi' : 'Belum Verifikasi',
      strtoupper($registration->status_kelulusan ?? 'PENDING'),
    ];
  }
}
