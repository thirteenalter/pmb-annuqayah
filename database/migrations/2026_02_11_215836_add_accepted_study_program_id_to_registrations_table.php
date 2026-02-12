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
    Schema::table('registrations', function (Blueprint $table) {
      $table->foreignId('accepted_study_program_id')
        ->nullable()
        ->constrained('study_programs')
        ->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('registrations', function (Blueprint $table) {
      $table->dropForeign(['accepted_study_program_id']);
      $table->dropColumn('accepted_study_program_id');
    });
  }
};
