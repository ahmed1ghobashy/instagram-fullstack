<?php

use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('login');
});
Route::get('search', function () {
    return view('search');
});
Route::get('login', function () {
    return view('login');
});
Route::get('signup', function () {
    return view('signup');
});
Route::get('home', function () {
    return view('home');
});


Route::get('edit-profile', [UserController::class, 'editProfile']);
Route::get('visit-profile/{profileId}', [UserController::class,'visitProfile']);
Route::get('profile', [UserController::class,'profile']);
Route::get('follow/{userId}',[UserController::class,'follow']);
Route::get('unfollow/{userId}',[UserController::class,'unfollow']);
Route::get('logout', [UserController::class,'logout']);
Route::get('post/{id}', [UserController::class,'postPage']);
Route::get('home', [UserController::class,'homePage']);
Route::get('like/{imageId}', [UserController::class,'like']);
Route::get('likes/{imageId}', [UserController::class,'likes']);
Route::get('notifications', [UserController::class,'notificationsPage']);
Route::get('following/{userId}', [UserController::class,'following']);
Route::get('followers/{userId}', [UserController::class,'followers']);
Route::get('accept/{userId}', [UserController::class,'acceptFollow']);
Route::get('reject/{userId}', [UserController::class,'rejectFollow']);

Route::post('login',[UserController::class,'login']);
Route::post('signup',[UserController::class,'createUser']);
Route::post('update',[UserController::class,'update']);
Route::post('search', [UserController::class,'search']);
Route::post('uploadPost', [UserController::class,'uploadPost']);
Route::post('uploadPost', [UserController::class,'uploadPost']);
Route::post('addComment', [UserController::class,'addComment']);

