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
    Schema::create('validities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');

      $table->boolean('is_data_valid')->default(false);
      $table->boolean('is_payment_valid')->default(false);
      $table->enum('final_status', ['pending', 'valid', 'invalid'])->default('pending');

      $table->text('admin_note')->nullable();
      $table->timestamp('verified_at')->nullable();
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('validities');
  }
};
