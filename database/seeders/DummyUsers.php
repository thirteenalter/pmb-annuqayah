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
        'name'      => 'adnan',
        'email'     => 'adnan@gmail.com',
        'nik'       => '1234567890123456',
        'nama_ibu'  => 'Ibu Adnan',
        'role'      => 'admin', // Mengikuti permintaan sebelumnya agar ada admin
        'password'  => Hash::make('12345678'),
        'status'    => 'active',
        'registration_period_id' => 1,
      ],
      [
        'name'      => 'ridho',
        'email'     => 'ridho@gmail.com',
        'nik'       => '1234567890123457',
        'nama_ibu'  => 'Ibu Ridho',
        'role'      => 'user',
        'password'  => Hash::make('12345678'),
        'status'    => 'pending',
        'registration_period_id' => 1,
      ],
    ];

    foreach ($userData as $user) {
      User::create($user);
    }
  }
}
