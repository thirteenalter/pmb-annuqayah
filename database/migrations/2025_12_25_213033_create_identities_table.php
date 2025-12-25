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
    Schema::create('identities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');

      $table->string('full_name');          // Nama Lengkap (Sesuai Ijazah)
      $table->string('nik', 16)->unique();  // NIK (16 digit)
      $table->string('birth_place');        // Tempat Lahir
      $table->date('birth_date');           // Tanggal Lahir
      $table->enum('gender', ['L', 'P']);   // Jenis Kelamin (Laki-laki/Perempuan)

      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('identities');
  }
};
