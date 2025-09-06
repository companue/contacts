<?php

use Illuminate\Support\Facades\Route;
use Companue\Contacts\Http\Controllers\ContactController;
use Companue\Contacts\Http\Controllers\ContactDetailController;

Route::prefix('contact_details')->group(function () {
    Route::get('/', [ContactDetailController::class, 'index']);
    Route::get('{id}', [ContactDetailController::class, 'show']);
    Route::post('/', [ContactDetailController::class, 'store']);
    Route::put('{id}', [ContactDetailController::class, 'update']);
    Route::delete('{id}', [ContactDetailController::class, 'destroy']);
});

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('{id}', [ContactController::class, 'show']);
    Route::post('/', [ContactController::class, 'store']);
    Route::put('{id}', [ContactController::class, 'update']);
    Route::delete('{id}', [ContactController::class, 'destroy']);
});
