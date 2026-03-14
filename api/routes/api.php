<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StickerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('stickers')->group(function () {
    Route::get('/', [StickerController::class, 'index']);
    Route::post('/', [StickerController::class, 'store']);
    Route::get('/{stickerId}', [StickerController::class, 'show']);
    Route::delete('/{stickerId}', [StickerController::class, 'destroy']);
    Route::post('/{stickerId}/trade', [StickerController::class, 'trade']);
  });

  Route::prefix('images')->group(function () {
    Route::post('/upload', [ImageController::class, 'upload']);
  });
});
