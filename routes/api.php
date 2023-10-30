<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/account/deposit', [AccountController::class, 'deposit'])->middleware('auth:sanctum');
Route::post('/account/withdraw', [AccountController::class, 'withdraw'])->middleware('auth:sanctum');
Route::post('/account/transfer', [AccountController::class, 'transfer'])->middleware('auth:sanctum');

Route::get('/account/transactions', [AccountController::class, 'transactions'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
