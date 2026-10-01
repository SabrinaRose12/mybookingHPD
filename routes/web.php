<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────────────────
// GUEST ROUTES — Login & Register
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/mybooking-register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// ─────────────────────────────────────────────────────────────────────────────
// EMAIL VERIFICATION ROUTES — Auth, but not yet verified
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

// ─────────────────────────────────────────────────────────────────────────────
// AUTHENTICATED & VERIFIED USER ROUTES
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    // Dashboard — My Bookings
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');

    // Room Listing (browse available rooms)
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // Booking (create & cancel)
    Route::get('/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Reactive Panel API
    Route::get('/api/rooms/{room}/details', [RoomController::class, 'apiDetails'])->name('api.rooms.details');
    Route::get('/api/rooms/{room}/schedule', [RoomController::class, 'apiSchedule'])->name('api.rooms.schedule');

    // In-App Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::patch('read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::get('unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    });

    // ─────────────────────────────────────────────────────────────────────────
    // PROFILE ROUTES — For all authenticated users
    // ─────────────────────────────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings');

    // ─────────────────────────────────────────────────────────────────────────
    // CALENDAR ROUTES — For all authenticated users
    // ─────────────────────────────────────────────────────────────────────────
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/bookings', [CalendarController::class, 'getBookings'])->name('bookings');
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN ROUTES — Protected by auth + is_admin middleware
// (BOTH Super Admin AND Regular Admin can access)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin dashboard redirect
        Route::get('/', fn () => redirect()->route('admin.bookings.index'))->name('home');

        // MANAGE BOOKINGS — All admins can access (filtered by assigned rooms)
        Route::get('bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');
        Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('bookings.status');

        // MANAGE ROOMS — All admins can access (filtered by assigned rooms)
        Route::get('rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
        Route::get('rooms/create', [AdminRoomController::class, 'create'])->name('rooms.create');
        Route::post('rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
        Route::get('rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('rooms.edit');
        Route::put('rooms/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
        Route::delete('rooms/{room}/image', [AdminRoomController::class, 'deleteImage'])->name('rooms.image.delete');
        Route::delete('rooms/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');
    });

// ─────────────────────────────────────────────────────────────────────────────
// SUPER ADMIN ROUTES — Protected by auth + is_super middleware
// (ONLY Super Admin can manage users)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'is_super'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', AdminUserController::class);
    });

// ─────────────────────────────────────────────────────────────────────────────
// TEST ROUTE — For debugging
// ─────────────────────────────────────────────────────────────────────────────
Route::get('/test-route', function () {
    dd('TESTING');
})->middleware(['auth', 'is_super']);