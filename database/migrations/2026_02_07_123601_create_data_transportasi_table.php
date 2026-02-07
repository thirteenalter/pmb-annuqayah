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
    Schema::create('data_transportasi', function (Blueprint $table) {
      $table->float('id_alat_transport')->primary();
      $table->string('nm_alat_transport', 150)->nullable();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('data_transportasi');
  }
};
