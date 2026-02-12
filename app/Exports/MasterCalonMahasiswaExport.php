<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterCalonMahasiswaExport implements FromQuery, WithHeadings, WithMapping
{
  private $rowNumber = 0;

  public function query()
  {
    // Menambahkan eager loading untuk semua relasi agar export cepat (mencegah N+1)
    return Registration::query()->with([
      'user.identity',
      'user.document',
      'user.payment',
      'user.validity',
      'studentProfile',
      'studentFamily',
      'studentDetails.province', // Relasi ke tabel wilayah
      'studentDetails.city',
      'studentDetails.district',
      'studyProgram'
    ]);
  }

  public function headings(): array
  {
    return [
      'No',
      'No. Peserta',
      'NIM',
      'Nama Lengkap',
      'Email',
      'NIK',
      'No. WA/HP',
      'Prodi Pilihan 1',
      'Prodi Pilihan 2',
      'Diterima Prodi',
      'Sekolah Asal',
      'Tahun Lulus',
      'NISN',
      'Agama',
      'Kewarganegaraan',
      'Alamat (Jalan/Dusun)',
      'RT/RW',
      'Kelurahan',
      'Kecamatan',
      'Kota/Kabupaten',
      'Provinsi',
      'Nama Ayah',
      'Pekerjaan Ayah',
      'Penghasilan Ayah',
      'Nama Ibu',
      'Pekerjaan Ibu',
      'Penghasilan Ibu',
      'Status Bayar',
      'Status Verifikasi Data',
      'Status Kelulusan'
    ];
  }

  public function map($reg): array
  {
    $this->rowNumber++;
    $user = $reg->user;
    $details = $reg->studentDetails;
    $profile = $reg->studentProfile;
    $family = $reg->studentFamily;

    return [
      $this->rowNumber,
      $reg->participant_number ?? '-',
      "'" . ($reg->nim ?? '-'), // Petik satu agar nol di depan tidak hilang
      $user->identity?->full_name ?? $user->name,
      $user->email,
      "'" . ($user->identity?->nik ?? '-'),
      "'" . ($details?->hp ?? $user->identity?->phone_number ?? '-'),
      $reg->studyProgram?->name ?? '-',
      $reg->secondStudyProgram?->name ?? '-',
      $reg->acceptedStudyProgram?->name ?? '-',
      $reg->school_origin ?? '-',
      $reg->graduation_year ?? '-',
      "'" . ($details?->nisn ?? $profile?->nisn ?? '-'),
      $profile?->religion ?? '-',
      $details?->kewarganegaraan ?? '-',
      ($details?->jalan ?? '') . ' ' . ($details?->dusun ?? ''),
      ($details?->rt ?? '0') . '/' . ($details?->rw ?? '0'),
      $details?->kelurahan ?? '-',
      // Mengambil dari relasi ID jika ada, jika tidak pakai string manual
      $details?->district?->nm_wil ?? $details?->kecamatan ?? '-',
      $details?->city?->nm_wil ?? $details?->kabupaten_kota ?? '-',
      $details?->province?->nm_wil ?? $details?->provinsi ?? '-',

      $family?->nama_ayah ?? $family?->nama_ayah ?? '-',
      $family?->pekerjaan_ayah ?? $family?->pekerjaan_ayah ?? '-',
      $family?->penghasilan_ayah ?? '-',
      $family?->nama_ibu ?? $family?->nama_ibu ?? '-',
      $family?->pekerjaan_ibu ?? '-',
      $family?->penghasilan_ibu ?? '-',

      strtoupper($user->payment?->status ?? 'BELUM BAYAR'),
      ($user->validity?->is_data_valid == 1) ? "Terverifikasi" : "Belum Valid",
      strtoupper($reg->status_kelulusan ?? 'PENDING'),
    ];
  }
}
