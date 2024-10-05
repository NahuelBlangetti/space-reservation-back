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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('spaces', [SpaceController::class, 'index']);
Route::get('spaces/{id}', [SpaceController::class, 'showSpace']);

Route::middleware(['auth:api'])->group(function () {
    

    Route::get('reservations', [ReservationController::class, 'index']);
    Route::get('reservations/{id}', [ReservationController::class, 'show']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::put('reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy']);
    

    Route::put('spaces/{space}', [SpaceController::class, 'update']);
    Route::put('spaces/available/{space}', [SpaceController::class, 'updateAvailable']);
    Route::post('spaces', [SpaceController::class, 'store']);

});    


