<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AnalyticsController;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TrackingController;
use App\Http\Controllers\DisplayAnalyticsData;
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
Route::post('/password-confirm', [AuthController::class, 'passwordConfirm']); 
Route::post('/password-reset-request', [AuthController::class, 'sendPasswordResetEmail']);
Route::post('/password-reset', [AuthController::class, 'resetPassword']);
Route::get('/logged-in-user', [AuthController::class, 'checkUser']);



Route::middleware('auth')->group(function () {
    // authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});


Route::middleware(['throttle:1000,1'])->group(function () {
    Route::post('/sites', [TrackingController::class, 'registerSite'])->name('sites.register');
    Route::post('/track', [TrackingController::class, 'trackEvent'])->name('track.event');
    Route::get('/analytics', [TrackingController::class, 'getAnalytics'])->name('analytics.get');
    Route::get('/script.js', [TrackingController::class, 'getTrackingScript'])->name('tracker.script');

    // handle the display of the data
    Route::post('/track/dynamic', [DisplayAnalyticsData::class, 'trackDynamicEvent'])->name('track.dynamic');
    Route::get('/dashboard', [DisplayAnalyticsData::class, 'showAnalyticsDashboard'])->name('analytics.dashboard');
});


