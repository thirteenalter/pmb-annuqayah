<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
  protected $fillable = ['name', 'faculty', 'is_active'];

  public function registrations()
  {
    return $this->hasMany(Registration::class, 'study_program_id');
  }
}
