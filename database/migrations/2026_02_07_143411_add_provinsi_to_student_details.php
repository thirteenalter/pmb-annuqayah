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
    Schema::table('student_details', function (Blueprint $table) {
      $table->string('provinsi')->after('npwp')->nullable();
      $table->char('province_id', 8)->nullable();
      $table->char('city_id', 8)->nullable();
      $table->char('district_id', 8)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('student_details', function (Blueprint $table) {
      //
    });
  }
};
