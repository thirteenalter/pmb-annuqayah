<?php

namespace App\Models\Student;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentFamily extends Model
{
  protected $fillable = [
    'registration_id',
    'nik_ayah',
    'nama_ayah',
    'tgl_lahir_ayah',
    'pendidikan_ayah',
    'pekerjaan_ayah',
    'penghasilan_ayah',
    'nik_ibu',
    'nama_ibu',
    'tgl_lahir_ibu',
    'pendidikan_ibu',
    'pekerjaan_ibu',
    'penghasilan_ibu',
  ];

  protected $casts = [
    'tgl_lahir_ayah' => 'date',
    'tgl_lahir_ibu' => 'date',
  ];

  public function registration(): BelongsTo
  {
    return $this->belongsTo(Registration::class);
  }
}
