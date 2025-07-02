<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AnalyticsController;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TrackingController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



// email server test
Route::get('test-email', function () {
    try {
        Mail::raw('This is a test email.', function ($message) {
            $message->to('webmasterjdd@gmail.com')
                ->subject('Test Email for the specialist Endpoint');
        });

        return 'Test email sent successfully.';
    } catch (\Exception $e) {
        return 'Failed to send test email: ' . $e->getMessage();
    }
});

// authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/resend-verification-code', [AuthController::class, 'resendVerificationEmail'])->name('resend-verification');
Route::post('/password-confirm', [AuthController::class, 'passwordConfirm']); //  YET TO BE IMPLEMENTED
Route::post('/password-reset-request', [AuthController::class, 'sendPasswordResetEmail']);
Route::post('/password-reset', [AuthController::class, 'resetPassword']);
Route::get('/logged-in-user', [AuthController::class, 'checkUser']);



Route::middleware('auth')->group(function () {
    // authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

   

});





Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('api.key');
Route::post('/sites', [AuthController::class, 'registerSite'])->middleware('api.key');

Route::middleware(['api.key', 'throttle:1000,1'])->group(function () {
    Route::post('/track/pageview', [TrackingController::class, 'trackPageView']);
    Route::get('/page-views', [TrackingController::class, 'getPageViews']);
    Route::get('/page-insights', [TrackingController::class, 'getPageInsights']);
    Route::post('/track/click', [TrackingController::class, 'trackClick']);
    Route::get('/analytics/pageviews', [AnalyticsController::class, 'pageViews']);
    Route::get('/analytics/pageviews/by-page', [AnalyticsController::class, 'pageViewsByPage']);
    Route::get('/analytics/session-duration', [AnalyticsController::class, 'sessionDuration']);
    Route::get('/analytics/geolocation', [AnalyticsController::class, 'geolocation']);
    Route::get('/analytics/clicks', [AnalyticsController::class, 'clicks']);
    Route::get('/analytics/clicks/by-element', [AnalyticsController::class, 'clicksByElement']);
});

Route::middleware(['api.key', 'admin'])->group(function () {
    Route::get('/analytics/all-pageviews', [AdminController::class, 'allPageViews']);
});