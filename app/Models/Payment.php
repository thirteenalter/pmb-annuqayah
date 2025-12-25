<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $fillable = [
    'user_id',
    'account_name',
    'proof_file',
    'status'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
