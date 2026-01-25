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
    'kelurahan',
    'kecamatan',
    'kode_pos',
    'telepon',
    'hp',
    'email',
    'penerima_kps',
    'alat_transportasi',
    'jenis_tinggal',
    'kebutuhan_khusus_mahasiswa',
    'kebutuhan_khusus_ayah',
    'kebutuhan_khusus_ibu'
  ];

  public function registration(): BelongsTo
  {
    return $this->belongsTo(Registration::class);
  }
}
