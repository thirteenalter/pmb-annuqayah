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
    Schema::create('registration_periods', function (Blueprint $table) {
      $table->id();
      $table->string('name'); // Contoh: Gelombang 1
      $table->integer('price'); // Contoh: 250000
      $table->dateTime('start_date');
      $table->dateTime('end_date');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::dropIfExists('registration_periods');

    // Aktifkan kembali
    Schema::enableForeignKeyConstraints();
  }
};
