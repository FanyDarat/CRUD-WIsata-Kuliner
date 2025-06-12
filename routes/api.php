<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\WikulinerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/user", function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => $request->user()
        ]);
    });
    
    Route::post("/wikul", [WikulinerController::class, 'store']);
    Route::put("/wikul/{id_wikul}", [WikulinerController::class, 'update']);
    Route::delete("/wikul/{id_wikul}", [WikulinerController::class, 'destroy']);
});
    
Route::get("/wikul", [WikulinerController::class, 'index']);
Route::get("/wikul/image/{id_wikul}", [WikulinerController::class, 'getImage']);
    


