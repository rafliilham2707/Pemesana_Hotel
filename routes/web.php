<?php

use App\Http\Controllers\Admin\BookingManagementController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/hotels/{slug}', [HotelController::class, 'show'])->name('hotels.show');

// Component Demo
Route::get('/demo-components', function () {
    return view('demo-components');
})->name('demo-components');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Wishlist
    Route::post('/hotels/{hotel}/wishlist', [WishlistController::class, 'toggle'])->name('account.wishlist.toggle');
    Route::get('/account/wishlist', [WishlistController::class, 'index'])->name('account.wishlist');

    // Profile & Bookings (Customer Account)
    Route::get('/account/profile', [ProfileController::class, 'edit'])->name('account.profile');
    Route::put('/account/profile', [ProfileController::class, 'update'])->name('account.profile.update');
    Route::put('/account/password', [ProfileController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/account/bookings', [BookingController::class, 'index'])->name('account.bookings');
    Route::get('/account/bookings/{booking:booking_code}', [BookingController::class, 'show'])->name('account.bookings.show');
    Route::post('/account/bookings/{booking:booking_code}/cancel', [BookingController::class, 'cancel'])->name('account.bookings.cancel');

    // Booking Flow
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking:booking_code}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking:booking_code}/pay', [BookingController::class, 'processPayment'])->name('booking.pay');
    Route::get('/booking/{booking:booking_code}/success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/{booking:booking_code}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');
    Route::post('/booking/voucher/check', [BookingController::class, 'checkVoucher'])->name('booking.voucher.check');

    // Reviews
    Route::post('/hotels/{hotel}/reviews', [HotelController::class, 'storeReview'])->name('hotels.reviews.store');
});

// Admin Routes Group
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Hotels Management
    Route::resource('hotels', AdminHotelController::class);
    Route::post('hotels/{hotel}/toggle-status', [AdminHotelController::class, 'toggleStatus'])->name('hotels.toggle-status');

    // Room Types Management (Nested within hotel)
    Route::resource('hotels.rooms', AdminRoomTypeController::class);
    Route::get('hotels/{hotel}/rooms/{room}/inventories', [AdminRoomTypeController::class, 'inventories'])->name('hotels.rooms.inventories');
    Route::post('hotels/{hotel}/rooms/{room}/inventories', [AdminRoomTypeController::class, 'updateInventories'])->name('hotels.rooms.inventories.update');

    // Bookings Management
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking:booking_code}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking:booking_code}/confirm-payment', [AdminBookingController::class, 'confirmPayment'])->name('bookings.confirm-payment');
    Route::post('bookings/{booking:booking_code}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking:booking_code}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');

    // Vouchers Management
    Route::resource('vouchers', AdminVoucherController::class);
    Route::post('vouchers/{voucher}/toggle-status', [AdminVoucherController::class, 'toggleStatus'])->name('vouchers.toggle-status');

    // Reviews Moderation
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Users Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
});
