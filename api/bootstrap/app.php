<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    //
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (ValidationException $e) {
      $messages = collect($e->errors())
        ->map(function ($messages) {
          return $messages[0];
        })
        ->toArray();

      return response()->json([
        "type" => "Validation",
        "fieldErrors" => $messages
      ], 422);
    });
  })->create();
