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
    Schema::create('custom_fields', function (Blueprint $table) {
      $table->id();
      $table->string('label');          // Judul Input (ex: "Ukuran Baju")
      $table->string('name');           // Nama slug (ex: "ukuran_baju")
      $table->string('type');           // Tipe (text, number, file, date, select)
      $table->text('description')->nullable(); // Deskripsi/Instruksi
      $table->enum('category', ['registration', 'document']); // Muncul di page mana?
      $table->boolean('is_required')->default(false);
      $table->json('options')->nullable(); // Untuk tipe 'select' (opsi pilihan)
      $table->integer('order')->default(0); // Urutan tampil
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
