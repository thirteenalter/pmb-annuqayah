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
    Schema::table('student_profiles', function (Blueprint $table) {
      $table->string('nama_pondok')->nullable()->after('religion');
      $table->string('alamat_pondok')->nullable()->after('nama_pondok');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('student_profiles', function (Blueprint $table) {
      //
    });
  }
};
