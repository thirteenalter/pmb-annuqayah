<?php

namespace App\Models\Student;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDetails extends Model
{
  protected $fillable = [
    'registration_id',
    'kewarganegaraan',
    'nisn',
    'npwp',
    'jalan',
    'dusun',
    'rt',
    'rw',
    'provinsi',        // Menyimpan Nama String
    'province_id',     // Helper ID
    'kabupaten_kota',  // Menyimpan Nama String
    'city_id',         // Helper ID
    'kecamatan',       // Menyimpan Nama String
    'district_id',     // Helper ID
    'kelurahan',
    'kode_pos',
    'telepon',
    'hp',
    'email',
    'penerima_kps',
    'alat_transportasi', // Menyimpan Nama String
    'jenis_tinggal',     // Menyimpan Nama String
    'kebutuhan_khusus_mahasiswa',
    'kebutuhan_khusus_ayah',
    'kebutuhan_khusus_ibu'
  ];

  public function registration(): BelongsTo
  {
    return $this->belongsTo(Registration::class);
  }
}
