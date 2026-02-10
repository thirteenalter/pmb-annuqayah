<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyUsers extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $userData = [
      [
        'name'      => 'administrator',
        'email'     => env('APP_USERNAME_ADMIN'),
        'nik'       => '1234567890123456',
        'nama_ibu'  => '-',
        'role'      => 'admin',
        'password'  => Hash::make(env('APP_PASSWORD_ADMIN')),
        'status'    => 'active',
        'registration_period_id' => 1,
      ]
    ];

    foreach ($userData as $user) {
      User::create($user);
    }
  }
}
