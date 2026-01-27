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
    Schema::table('settings', function (Blueprint $table) {
      $table->string("nowa")->nullable()->default("08123456789");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('settings', function (Blueprint $table) {
      //
    });
  }
};
