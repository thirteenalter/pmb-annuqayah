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
    Schema::create('student_families', function (Blueprint $table) {
      $table->id();
      $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');

      $table->string('nik_ayah')->nullable();
      $table->string('nama_ayah')->nullable();
      $table->date('tgl_lahir_ayah')->nullable();
      $table->string('pendidikan_ayah')->nullable();
      $table->string('pekerjaan_ayah')->nullable();
      $table->string('penghasilan_ayah')->nullable();

      $table->string('nik_ibu')->nullable();
      $table->string('nama_ibu')->nullable();
      $table->date('tgl_lahir_ibu')->nullable();
      $table->string('pendidikan_ibu')->nullable();
      $table->string('pekerjaan_ibu')->nullable();
      $table->string('penghasilan_ibu')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
