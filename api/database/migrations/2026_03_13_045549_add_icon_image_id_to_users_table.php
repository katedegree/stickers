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
    Schema::table('users', function (Blueprint $table) {
      $table->unsignedBigInteger('icon_image_id')->nullable();

      $table->foreign('icon_image_id')
        ->references('id')
        ->on('images')
        ->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['icon_image_id']);
      $table->dropColumn('icon_image_id');
    });
  }
};
