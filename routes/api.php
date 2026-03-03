<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Middleware\setLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
//api routes


Route::group(['middleware' => setLang::class], function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('products', [ProductController::class, 'index']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('redirect/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('callback/{provider}', [AuthController::class, 'handleProviderCallback']);
    Route::post('resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('email-verified', [AuthController::class, 'emailVerified']);
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('verify-otp', [ForgetPasswordController::class, 'verifyOtp']);
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('resend-otp-password', [ForgetPasswordController::class, 'resendOtp']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
    });
});
