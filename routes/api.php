<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    
    //Route::middleware('auth:sanctum')->group(function () {

        //Route::get('test-oxylabs', [OxyLabsController::class, 'testOxylabs']);

        //Route::get('test-xpath', [XpathController::class, 'testXpath']);

        
        //Route::get('test-scraping', [XpathController::class, 'getScrapingBee']);
    //});
    
    
});

