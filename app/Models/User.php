<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'nik',
    'nama_ibu',
    'role',
    'password',
    'status',
    'registration_period_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function isAdmin(): bool
  {
    return ($this->role ?? null) === 'admin';
  }

  public function identity(): HasOne
  {
    return $this->hasOne(Identity::class);
  }

  public function registration(): HasOne
  {
    return $this->hasOne(Registration::class);
  }

  public function document(): HasOne
  {
    return $this->hasOne(Document::class);
  }

  public function payment(): HasOne
  {
    return $this->hasOne(Payment::class);
  }

  public function validity(): HasOne
  {
    return $this->hasOne(Validity::class, 'user_id', 'id');
  }

  public function registrationPeriod()
  {
    return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
  }

  public function customFieldValues()
  {
    return $this->hasMany(CustomFieldValue::class);
  }
}
