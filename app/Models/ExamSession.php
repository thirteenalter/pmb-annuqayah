<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSession extends Model
{
  // Ini biar kaga error "Add [kolom] to fillable"
  protected $fillable = [
    'user_id',
    'exam_id',
    'score',
    'status', // 'started', 'finished'
  ];

  // Hubungin ke User (Siapa yang ujian)
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  // Hubungin ke Exam (Ujian yang mana)
  public function exam(): BelongsTo
  {
    return $this->belongsTo(Exam::class);
  }
}
