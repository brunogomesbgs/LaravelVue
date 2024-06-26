<?php

use App\Http\Controllers\UrlController;
use App\Http\Controllers\User;
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

Route::controller(UrlController::class)->prefix('/api/urls')->group(function () {
    $id = '/{id}';

    Route::post('/', 'store');
    Route::post('/listAll', 'index');
    Route::get($id, 'show');
    Route::get($id.'/showUrlWithLinks', 'showUrlWithLinks');
    Route::put($id, 'update');
    Route::delete($id, 'destroy');
});
