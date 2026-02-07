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
    Schema::create('data_wilayah', function (Blueprint $table) {
      $table->char('id_wil', 8)->primary();
      $table->string('nm_wil', 50);
      $table->string('id_induk_wilayah', 50)->nullable();
      $table->integer('id_level_wil');

      // Indexing berdasarkan ref.sql
      $table->index('id_induk_wilayah');
      $table->index('id_wil');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('data_wilayah');
  }
};
