<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Student\StudentProfile;
use App\Models\Student\StudentFamily;
use App\Models\Student\StudentDetails;

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

  public function studentProfile()
  {
    return $this->hasOne(StudentProfile::class);
  }

  public function studentFamily()
  {
    return $this->hasOne(StudentFamily::class);
  }

  public function studentDetails()
  {
    return $this->hasOne(StudentDetails::class);
  }

  public function period(): BelongsTo
  {
    return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
  }
}
