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
    Schema::create('exam_sessions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
      $table->timestamp('start_at')->nullable();
      $table->timestamp('completed_at')->nullable();
      $table->integer('score')->default(0);
      $table->enum('status', ['progress', 'done'])->default('progress');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_sessions');
  }
};
