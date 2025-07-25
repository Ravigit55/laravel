<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/admin/members', [AdminController::class, 'memberList'])->name('admin.members');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/member/create', [AdminController::class, 'createMember'])->name('admin.member.create');
    Route::post('/admin/member/store', [AdminController::class, 'storeMember'])->name('admin.member.store');
});