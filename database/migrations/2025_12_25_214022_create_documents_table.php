<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('photo_formal')->nullable(); // Tambahkan nullable
      $table->string('ktp_scan')->nullable();     // Tambahkan nullable
      $table->string('kk_scan')->nullable();      // dan seterusnya...
      $table->string('ijazah_scan')->nullable();
      $table->string('report_scan')->nullable();
      $table->string('achievement_certificate')->nullable();
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('documents');
  }
};
