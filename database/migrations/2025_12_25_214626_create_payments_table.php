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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      // Tetap berelasi dengan users
      $table->foreignId('user_id')->constrained()->onDelete('cascade');

      $table->string('account_name');      // Nama Pengirim di Rekening (sesuai gambar)
      $table->string('proof_file');        // File bukti transfer

      // Status verifikasi awal
      $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payments');
  }
};
