<?php

use App\Http\Controllers\Deposit;
use App\Http\Controllers\Purchase;
use App\Http\Controllers\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::controller(User::class)->prefix('/api/users')->group(function () {
    Route::post('/addUser', 'addUser');
    Route::post('/logIn', 'logIn');
    Route::get('/getAll', 'getAll');
});

Route::controller(Deposit::class)->prefix('/api/deposits')->group(function () {
    Route::post('/makeDeposit', 'makeDeposit');
    Route::get('/checkUserBalance', 'checkUserBalance');
    Route::post('/listUserBalance', 'listUserBalance');
    Route::get('/listPendingDeposit', 'listPendingDeposit');
    Route::post('/evaluateDeposit', 'evaluateDeposit');
});

Route::controller(Purchase::class)->prefix('/api/purchases')->group(function () {
    Route::post('/makePurchase', 'makePurchase');
});
