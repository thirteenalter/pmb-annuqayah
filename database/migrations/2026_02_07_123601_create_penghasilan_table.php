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
    Schema::create('penghasilan', function (Blueprint $table) {
      $table->float('id_penghasilan')->primary();
      $table->string('nm_penghasilan', 50)->nullable()->default('0');
      $table->integer('batas_bawah')->nullable()->default(0);
      $table->integer('batas_atas')->nullable()->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('penghasilan');
  }
};
