<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomField extends Model
{
  use HasFactory;

  protected $fillable = [
    'label',
    'name',
    'type',
    'description',
    'category',
    'is_required',
    'options',
    'order'
  ];

  protected $casts = [
    'is_required' => 'boolean',
    'options' => 'array', // Otomatis mengubah JSON di DB menjadi Array PHP
  ];

  /**
   * Relasi ke nilai/jawaban yang diinput oleh user
   */
  public function values(): HasMany
  {
    return $this->hasMany(CustomFieldValue::class);
  }
}
