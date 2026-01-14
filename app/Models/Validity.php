<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validity extends Model
{
  //
  // app/Models/Validity.php

  protected $fillable = [
    'user_id',
    'is_data_valid',
    'is_payment_valid',
    'is_document_valid',
    'final_status',
    'admin_note',
    'verified_at'
  ];

  protected $casts = [
    'is_document_valid' => 'boolean',
  ];


  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
