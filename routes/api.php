<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PointController;



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
Route::post('/points/calculate', [PointController::class, 'calculatePoints']);
Route::post('/points/add', [PointController::class, 'addManualPoints']);
Route::post('/points/redeem', [PointController::class, 'redeemPoints']);
Route::get('/member/{code}/points', [MemberController::class, 'getPoints']);

Route::post('/members', [MemberController::class, 'store']);
Route::post('/member/login', [MemberController::class, 'login']);
Route::get('/member/profile', [MemberController::class, 'profile']);
Route::get('/member/points', [MemberController::class, 'getPointsByQuery']);
Route::post('/transactions/add', [TransactionController::class, 'store']);
Route::get('/transactions/transactions_history', [TransactionController::class, 'getPurchaseHistory']);


