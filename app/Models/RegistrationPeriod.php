<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPeriod extends Model
{
  use HasFactory;

  protected $table = 'registration_periods';

  protected $fillable = [
    'name',
    'price',
    'start_date',
    'end_date',
    'is_active'
  ];

  protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
    'is_active' => 'boolean',
  ];

  public function users()
  {
    return $this->hasMany(User::class, 'registration_period_id');
  }

  public function registrations(): HasMany
  {
    return $this->hasMany(Registration::class, 'registration_period_id');
  }
}
