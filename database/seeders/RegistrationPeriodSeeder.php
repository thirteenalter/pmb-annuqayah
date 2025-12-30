<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationPeriod;

class RegistrationPeriodSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    RegistrationPeriod::create([
      'name' => 'Gelombang 1 - Jalur Reguler',
      'price' => 250000,
      'start_date' => now(),
      'end_date' => now()->addMonths(2),
      'is_active' => true,
    ]);
  }
}
