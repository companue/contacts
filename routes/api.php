

<?php

use Illuminate\Support\Facades\Route;
use Companue\Contacts\Http\Controllers\ContactController;

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('{id}', [ContactController::class, 'show']);
    Route::post('/', [ContactController::class, 'store']);
    Route::put('{id}', [ContactController::class, 'update']);
    Route::delete('{id}', [ContactController::class, 'destroy']);
});
