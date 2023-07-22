<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{LoginController,RegisterController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth', 'role::admin'])->group(function () {
    Route::get('/private', function ($id) {
        return  "Bonjour admin";
        
    });

    
    
});
Route::post('/login',[LoginController::class ,'login']);
/*     Route::post('/register',[RegisterController::class ,'register']);
Route::post('/otp',[RegisterController::class ,'otp']);
Route::post('/verifyotp',[RegisterController::class ,'verifyotp']); */
Route::middleware('api')->post('/register', [RegisterController::class, 'register']);
Route::middleware('api')->post('/verifiedOtp', [RegisterController::class, 'verifiedOtp']);
Route::get('/verification/{id}',[RegisterController::class,'verification']);


