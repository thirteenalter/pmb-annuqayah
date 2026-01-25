<?php

namespace App\Models\Student;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
  protected $fillable = [
    'registration_id',
    'religion',
    'nisn',
    'nama_pondok',
    'alamat_pondok'
  ];

  public function registration(): BelongsTo
  {
    return $this->belongsTo(Registration::class);
  }
}
