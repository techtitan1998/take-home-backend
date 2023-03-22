<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegistrationController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::get('check-Token',[loginController::class,'checkToken']);

Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
Route::post('reset-password/{id}', [LoginController::class, 'reset']);


Route::middleware('auth:api')->group(function() {

    Route::get('/show-profile', [ProfileController::class, 'index']);
    Route::post('/profile-edit/{id}', [ProfileController::class, 'editProfile']);
    Route::post('/profile-update/{id}', [ProfileController::class, 'updateProfile']);
 
});

Route::post('/logout',[LoginController::class,"logout"])->name("logout");



