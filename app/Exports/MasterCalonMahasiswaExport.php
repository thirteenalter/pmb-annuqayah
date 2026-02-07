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
      'NIM',
      'Nama Lengkap',
      'Email',
      'NIK',
      'WA',
      'Prodi',
      'Sekolah Asal',
      'NISN',
      'Agama',
      'Alamat (Jalan)',
      'Provinsi',
      'Kecamatan',
      'Kota/Kab',
      'Nama Ayah',
      'Pekerjaan Ayah',
      'Nama Ibu',
      'Status Bayar',
      'Status Verifikasi Data',
      'Lulus'
    ];
  }

  public function map($reg): array
  {
    return [
      $reg->participant_number,
      $reg->registration->nim ?? '-',
      $reg->user->identity->full_name ?? $reg->user->name,
      $reg->user->email,
      $reg->user->identity->nik ?? '-',
      $reg->studentDetails->hp ?? '-',
      $reg->studyProgram->name ?? '-',
      $reg->school_origin,
      $reg->studentProfile->nisn ?? '-',
      $reg->studentProfile->religion ?? '-',
      $reg->studentDetails->jalan ?? '-',
      $reg->studentDetails->provinsi ?? '-',
      $reg->studentDetails->kecamatan ?? '-',
      $reg->studentDetails->kabupaten_kota ?? '-',
      $reg->studentFamily->nama_ayah ?? '-',
      $reg->studentFamily->pekerjaan_ayah ?? '-',
      $reg->studentFamily->nama_ibu ?? '-',
      $reg->user->payment?->status ?? 'Belum Bayar',
      $reg->user->validity?->final_status == "valid" ? "Terverifikasi" : "Invalid",
      $reg->user->registration?->status_kelulusan ?? 'Pending',
    ];
  }
}
