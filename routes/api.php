<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AlergiaController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

/**
 * Alergias (escopadas pelo usuário autenticado)
 * Mantém o padrão simples e direto, com CRUD.
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/alergias', [AlergiaController::class, 'index']);
    Route::post('/alergias', [AlergiaController::class, 'store']);
    Route::get('/alergias/{alergia}', [AlergiaController::class, 'show']);
    Route::put('/alergias/{alergia}', [AlergiaController::class, 'update']);
    Route::delete('/alergias/{alergia}', [AlergiaController::class, 'destroy']); 
});
