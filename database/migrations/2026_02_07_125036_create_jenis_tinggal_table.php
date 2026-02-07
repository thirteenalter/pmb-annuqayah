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
    Schema::create('jenis_tinggal', function (Blueprint $table) {
      $table->float('id_jns_tinggal')->primary();
      $table->string('nm_jns_tinggal', 50);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('jenis_tinggal');
  }
};
