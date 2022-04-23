<?php

use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/signup', [HomeController::class, 'signup']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/signupAction', [LoginController::class, 'signup'])->name('signupAction');
Route::post('/loginAction', [LoginController::class, 'login'])->name('loginAction');
// group middleware to prevent back
Route::group(['middleware' => ['preventBack']], function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('/activities', [DashBoardController::class, 'activities']);
    Route::get('/activity_load/{userId}', [DashBoardController::class, 'activity_load'])->name('activity.load');
    Route::get('/activity/{id}', [DashBoardController::class, 'activities_edit']);
    Route::put('/activity_save/{id}', [DashBoardController::class, 'activities_save']);
    Route::get('/activity_fetch/{activity}', [DashBoardController::class, 'fetch_activity']);
    Route::post('/activity_add/{id}', [DashBoardController::class, 'activity_add']);
    Route::delete('/activity_delete/{id}', [DashBoardController::class, 'activity_delete']);
});
