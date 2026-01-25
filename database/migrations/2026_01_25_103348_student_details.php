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
    Schema::create('student_details', function (Blueprint $table) {
      $table->id();
      $table->foreignId('registration_id')->unique()->constrained('registrations')->onDelete('cascade');

      $table->string('kewarganegaraan')->default('Indonesia');
      $table->string('nisn', 10)->nullable();
      $table->string('npwp')->nullable();

      $table->string('jalan')->nullable();
      $table->string('dusun')->nullable();
      $table->string('rt', 5)->nullable();
      $table->string('rw', 5)->nullable();
      $table->string('kelurahan')->nullable();
      $table->string('kecamatan')->nullable();
      $table->string('kode_pos', 5)->nullable();

      $table->string('telepon')->nullable();
      $table->string('hp')->nullable();
      $table->string('email')->nullable();

      $table->string('penerima_kps')->nullable();
      $table->string('alat_transportasi')->nullable();
      $table->string('jenis_tinggal')->nullable();

      $table->string('kebutuhan_khusus_mahasiswa')->nullable()->default('Tidak Ada');
      $table->string('kebutuhan_khusus_ayah')->nullable()->default('Tidak Ada');
      $table->string('kebutuhan_khusus_ibu')->nullable()->default('Tidak Ada');
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
