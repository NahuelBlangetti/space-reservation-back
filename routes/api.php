<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:api'])->group(function () {
    
    // Rutas para la gestión de espacios
    Route::apiResource('spaces', SpaceController::class);

    // Rutas para la gestión de reservas
    Route::apiResource('reservations', ReservationController::class);
    
});    


