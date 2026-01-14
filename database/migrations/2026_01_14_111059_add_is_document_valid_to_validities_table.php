<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('validities', function (Blueprint $table) {
      $table->tinyInteger('is_document_valid')
        ->nullable()
        ->default(0)
        ->after('is_payment_valid');
    });
  }

  public function down(): void
  {
    Schema::table('validities', function (Blueprint $table) {
      $table->dropColumn('is_document_valid');
    });
  }
};
