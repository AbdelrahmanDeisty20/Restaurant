<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\GovernorateController;
use App\Http\Controllers\API\InformationController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderTrackingController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Middleware\setLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// api routes

Route::group(['middleware' => setLang::class], function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('best-sellers', [ProductController::class, 'getBestSellers']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('search', [ProductController::class, 'search']);
    Route::get('products-filter', [ProductController::class, 'filter']);
    Route::get('offers', [OfferController::class, 'index']);
    Route::get('product-extras', [ProductController::class, 'getProductExtras']);
    Route::get('product-sizes', [ProductController::class, 'getProductSizes']);
    Route::get('governorates', [GovernorateController::class, 'index']);
    // Information & Contact
    Route::get('pages', [InformationController::class, 'pages']);
    Route::get('pages/{slug}', [InformationController::class, 'page']);
    Route::get('settings', [InformationController::class, 'settings']);
    Route::post('contact', [ContactController::class, 'store']);

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
    Route::post('fcm-token', [NotificationController::class, 'sendToken']);
    Route::post('test-notification', [NotificationController::class, 'sendTestNotification']);
    Route::post('test-notification-users', [NotificationController::class, 'sendTestNotificationToUsers']);
 
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
        // Cart
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart', [CartController::class, 'add']);
        Route::put('cart/{productId}', [CartController::class, 'update']);
        Route::delete('cart/{productId}', [CartController::class, 'remove']);
        Route::delete('cart', [CartController::class, 'clear']);
        // Coupons
        Route::post('coupons/check', [CouponController::class, 'check']);
        Route::post('coupons/info', [CouponController::class, 'info']);
        // Order
        Route::post('orders/checkout', [OrderController::class, 'checkout']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/search', [OrderController::class, 'search']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
        Route::post('orders/{id}/delete', [OrderController::class, 'delete']);
        // Favorites
        Route::get('favorites', [FavoriteController::class, 'index']);
        Route::post('favorites/toggle', [FavoriteController::class, 'toggle']);

        // Addresses
        Route::get('addresses', [AddressController::class, 'index']);
        Route::post('addresses', [AddressController::class, 'store']);
        Route::put('addresses/{id}', [AddressController::class, 'update']);
        Route::delete('addresses/{id}', [AddressController::class, 'destroy']);

        // reviews
        Route::post('reviews', [ReviewController::class, 'store']);
        Route::post('products/{id}/reviews', [ReviewController::class, 'storeProductReview']);
        Route::get('products/{id}/reviews', [ReviewController::class, 'getProductReviews']);
        Route::get('my-reviews', [ReviewController::class, 'myReviews']);
        Route::put('product-reviews/{id}', [ReviewController::class, 'updateProductReview']);
        Route::delete('product-reviews/{id}', [ReviewController::class, 'deleteProductReview']);
        Route::put('order-reviews/{id}', [ReviewController::class, 'updateOrderReview']);
        Route::delete('order-reviews/{id}', [ReviewController::class, 'deleteOrderReview']);

        // Order Tracking
        Route::get('orders/{id}/track', [OrderTrackingController::class, 'show']);
        Route::post('driver/location', [OrderTrackingController::class, 'updateLocation']);

        // Notifications
        Route::post('fcm-token-user', [NotificationController::class, 'sendToken']);
    });
});
