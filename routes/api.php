<?php

use App\Http\Controllers\API\CategoryController;
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
});
