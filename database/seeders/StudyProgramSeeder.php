<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
  public function run(): void
  {
    $programs = [
      ['name' => 'Teknik Informatika', 'faculty' => 'Teknik', 'is_active' => true],
      ['name' => 'Teknik Sipil', 'faculty' => 'Teknik', 'is_active' => true],
      ['name' => 'Teknik Elektro', 'faculty' => 'Teknik', 'is_active' => true],
      ['name' => 'Sistem Informasi', 'faculty' => 'Teknik', 'is_active' => true],

      ['name' => 'Akuntansi', 'faculty' => 'Ekonomi & Bisnis', 'is_active' => true],
      ['name' => 'Manajemen', 'faculty' => 'Ekonomi & Bisnis', 'is_active' => true],
      ['name' => 'Ekonomi Pembangunan', 'faculty' => 'Ekonomi & Bisnis', 'is_active' => true],

      ['name' => 'Ilmu Komunikasi', 'faculty' => 'ISIP', 'is_active' => true],
      ['name' => 'Administrasi Publik', 'faculty' => 'ISIP', 'is_active' => true],
      ['name' => 'Hubungan Internasional', 'faculty' => 'ISIP', 'is_active' => true],
    ];

    foreach ($programs as $program) {
      StudyProgram::updateOrCreate(
        ['name' => $program['name']], // Unik berdasarkan nama
        $program
      );
    }
  }
}
