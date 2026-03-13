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
    Schema::create('histories', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('receiver_user_id')->nullable();
      $table->unsignedBigInteger('sticker_id');
      $table->timestamps();

      $table->foreign('receiver_user_id')
        ->references('id')
        ->on('users')
        ->onDelete('set null');
      $table->foreign('sticker_id')
        ->references('id')
        ->on('stickers')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('histories');
  }
};
