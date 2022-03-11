<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\AdminController;

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

Route::prefix('admin')->group(function (){
    Route::post('/register',[AdminController::class, 'register']);
    Route::post('/login',[AdminController::class, 'login']);
    Route::post('/add_art', [WorkController::class, 'add_art']);
    Route::get('/check_admin',[AdminController::class, 'check_admin'])->middleware('auth:admins');
});


