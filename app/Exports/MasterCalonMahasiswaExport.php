<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterCalonMahasiswaExport implements FromQuery, WithHeadings, WithMapping
{
  public function query()
  {
    // Ambil semua relasi yang ada di model Registration & User
    return Registration::query()->with([
      'user.identity',
      'user.document',
      'user.payment',
      'studentProfile',
      'studentFamily',
      'studentDetails',
      'studyProgram'
    ]);
  }

  public function headings(): array
  {
    return [
      'No. Peserta',
      'Nama Lengkap',
      'Email',
      'NIK',
      'WA',
      'Prodi',
      'Sekolah Asal',
      'NISN',
      'Agama',
      'Alamat (Jalan)',
      'Kecamatan',
      'Kota/Kab',
      'Nama Ayah',
      'Pekerjaan Ayah',
      'Nama Ibu',
      'Status Bayar',
      'Status Verifikasi'
    ];
  }

  public function map($reg): array
  {
    return [
      $reg->participant_number,
      $reg->user->identity->full_name ?? $reg->user->name,
      $reg->user->email,
      $reg->user->identity->nik ?? '-',
      $reg->studentDetails->hp ?? '-',
      $reg->studyProgram->name ?? '-',
      $reg->school_origin,
      $reg->studentProfile->nisn ?? '-',
      $reg->studentProfile->religion ?? '-',
      $reg->studentDetails->jalan ?? '-',
      $reg->studentDetails->kecamatan ?? '-',
      $reg->studentDetails->kabupaten ?? '-',
      $reg->studentFamily->nama_ayah ?? '-',
      $reg->studentFamily->pekerjaan_ayah ?? '-',
      $reg->studentFamily->nama_ibu ?? '-',
      $reg->user->payment->status ?? 'Belum Bayar',
      $reg->user->validity->status_verifikasi ?? 'Pending',
    ];
  }
}
