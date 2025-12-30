<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomFieldValue extends Model
{
  protected $fillable = [
    'user_id',
    'custom_field_id',
    'value'
  ];

  public function customField(): BelongsTo
  {
    return $this->belongsTo(CustomField::class);
  }

  /**
   * Relasi ke model User (Opsional)
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
