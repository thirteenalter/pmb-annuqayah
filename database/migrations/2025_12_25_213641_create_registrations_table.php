<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('registrations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('entry_path');     // Jalur Pendaftaran
      $table->string('participant_number')->nullable(); // Nomor Peserta
      $table->string('school_origin');  // Nama Sekolah Asal
      $table->year('graduation_year');  // Tahun Lulus
      $table->foreignId('study_program_id')->constrained()->onDelete('cascade');
      $table->string('achievement_certificate')->nullable();
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::dropIfExists('registrations');

    // Aktifkan kembali
    Schema::enableForeignKeyConstraints();
  }
};
