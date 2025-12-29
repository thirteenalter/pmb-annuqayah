<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
  protected $fillable = ['exam_id', 'question_text', 'image'];

  // Menghubungkan Soal ke Pilihan Jawaban
  public function options(): HasMany
  {
    return $this->hasMany(ExamOption::class);
  }
}
