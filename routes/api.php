<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersCourseController;
use App\Http\Controllers\UsersVideoController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('users')->group(function () {
    Route::put('/register', [UserController::class, 'register']);
    Route::post('/modify/{id}', [UserController::class, 'modify']);
});

Route::prefix('courses')->group(function () {
    Route::put('/registercourse', [CourseController::class, 'registercourse']);
    Route::get('/listcourses', [CourseController::class, 'listcourses']);
    Route::get('/listvideos/{user_id}', [CourseController::class, 'listvideos']);
});

Route::prefix('videos')->group(function () {
    Route::put('/registervideo', [VideoController::class, 'registervideo']);
});

Route::prefix('userscourses')->group(function () {
    Route::put('/acquirecourse', [UsersCourseController::class, 'acquirecourse']);
    Route::get('/listcourses/{id}', [UsersCourseController::class, 'listcourses']);
});

Route::prefix('usersvideos')->group(function () {
    Route::get('/showvideo/{user_id}', [UsersVideoController::class, 'showvideo']);
});
