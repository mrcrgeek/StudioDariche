<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactUsMessageController;
use App\Http\Controllers\ContactUsContentController;
use App\Http\Controllers\AboutUsController;
use App\Models\WeeklyWorks;

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

Route::prefix('/admin')->group(function (){
    //Auth
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);

    //works(slides)
    Route::post('/add_art', [WorkController::class, 'add_art'])->middleware('auth:admins');
    Route::patch('/update_art/{id}', [WorkController::class, 'update_art'])->middleware('auth:admins');
    Route::delete('/delete_art/{id}', [WorkController::class, 'delete_art'])->middleware('auth:admins');

    //middleware test
    Route::get('/check_admin', [AdminController::class, 'check_admin'])->middleware('auth:admins');
});

//get index Routes
Route::get('/index', [WorkController::class, 'get_art']);
Route::get('/index/{id}', [WorkController::class, 'get_by_id']);

//ContactUs Messages Route Routes(get,post)
Route::post('/ContactUsMessage', [ContactUsMessageController::class, 'store_message']);
Route::get('/ContactUsMessages', [ContactUsMessageController::class, 'get_messages'])->middleware('auth:admins');
Route::delete('/ContactUsMessage/{id}', [ContactUsMessageController::class, 'delete_message'])->middleware('auth:admins');
Route::get('/ContactUsMessages/{id}', [ContactUsMessageController::class, 'seen_message'])->middleware('auth:admins');
Route::get('/ContactUs/unseen_messages_count', [ContactUsMessageController::class, 'unseen_messages_count'])->middleware('auth:admins');

//ContactUs Content Routes
Route::patch('/ContactUsContent/update', [ContactUsContentController::class, 'update'])->middleware('auth:admins');
Route::get('/ContactUsContent/get', [ContactUsContentController::class, 'get']);

//AboutUs Routes
Route::patch('/AboutUs/update', [AboutUsController::class, 'update'])->middleware('auth:admins');
Route::get('/AboutUs/get', [AboutUsController::class, 'get']);

