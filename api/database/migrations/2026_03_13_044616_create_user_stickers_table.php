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
    Schema::create('user_stickers', function (Blueprint $table) {
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('sticker_id');
      $table->timestamps();

      $table->primary(['user_id', 'sticker_id']);

      $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
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
    Schema::dropIfExists('user_stickers');
  }
};
