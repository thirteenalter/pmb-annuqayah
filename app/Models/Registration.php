<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{

  protected $fillable = ['user_id', 'entry_path', 'participant_number', 'school_origin', 'graduation_year', 'study_program_id', 'registration_period_id',];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function studyProgram()
  {
    return $this->belongsTo(StudyProgram::class, 'study_program_id');
  }

  public function period(): BelongsTo
  {
    return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
  }
}
