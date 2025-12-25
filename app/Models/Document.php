<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Document extends Model
{
  protected $fillable = [
    'user_id',
    'photo_formal',
    'ktp_scan',
    'kk_scan',
    'ijazah_scan',
    'report_scan',
    'achievement_certificate'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  protected function photoFormalUrl(): Attribute
  {
    return Attribute::make(
      get: fn() => asset('storage/' . $this->photo_formal),
    );
  }
}
