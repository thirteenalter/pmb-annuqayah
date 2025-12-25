<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{

  protected $fillable = ['user_id', 'entry_path', 'participant_number', 'school_origin', 'graduation_year', 'study_program'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
