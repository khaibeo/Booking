<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffScheduleController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cashier\BookingController as CashierBookingController;
use App\Http\Controllers\Cashier\HomeController;
use App\Http\Controllers\Cashier\InvoiceController;
use App\Http\Controllers\Cashier\ReportController;
use App\Http\Controllers\Cashier\ServiceController as CashierServiceController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\ServiceController as ClientServiceController;
use App\Http\Controllers\Client\StoreController as ClientStoreController;
use App\Http\Controllers\Staff\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::prefix('login')->middleware('guest')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Dashboard
        // Route::get('/', function () {
        //     return view('dashboard');
        // })->name('dashboard');
        Route::match(['get', 'post'], '/', [AdminHomeController::class, 'index'])->name('dashboard');

        Route::middleware('checkRoleAdmin')->group(function () {
            // STORES
            Route::resource('stores', StoreController::class);
            Route::get('/{store}/staffs', [StoreController::class, 'showStoreStaffs'])->name('store.staffs');
            Route::get('opening-store/{id}', [StoreScheduleController::class, 'index'])->name('opening-store');
            Route::post('add-opening-store/{id}', [StoreScheduleController::class, 'store'])->name('add-opening-store');
            Route::put('update-opening-store/{storeId}/store_schedules/{id}', [StoreScheduleController::class, 'update'])->name('update-opening-store');
            Route::delete('delete-opening-store/{storeId}/store_schedules/{id}', [StoreScheduleController::class, 'destroy'])->name('delete-opening-store');

            // USERS
            Route::resource('users', UserController::class);

            Route::prefix('profile')->as('profile.')->group(function () {
                Route::get('/{user}', [ProfileController::class, 'show'])->name('show');
                Route::put('/{user}', [ProfileController::class, 'update'])->name('update');
                Route::put('/change-password/{user}', [ProfileController::class, 'changePassword'])->name('change-password');
            });

            // SERVICES_Categories
            Route::resource('service-category', ServiceCategoryController::class);

            // SERVICES
            Route::resource('services', ServiceController::class);

            Route::prefix('settings')->as('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'show'])->name('show');
                Route::put('/', [SettingController::class, 'update'])->name('update');
            });

            // BOOKINGS
            Route::prefix('/bookings')->as('bookings.')->group(function () {
                Route::get('/', [BookingController::class, 'index'])->name('index');
                Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
                Route::put('/update/{booking}', [BookingController::class, 'updateStatus'])->name('update');
                Route::post('cancel/{booking}', [BookingController::class, 'cancel'])->name('cancel');
            });
        });
        Route::middleware('role:staff')->prefix('staff')->as('staff.')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::prefix('bookings')->as('bookings.')->group(function () {
                Route::get('/', [BookingController::class, 'showBookingsForStaff'])->name('index');
                Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
            });

            Route::prefix('schedules')->as('schedules.')->group(function () {
                Route::get('/', [StaffScheduleController::class, 'index'])->name('index');
                Route::get('/create', [StaffScheduleController::class, 'create'])->name('create');
                Route::post('/', [StaffScheduleController::class, 'store'])->name('store');
                Route::get('/edit/{staffSchedule}', [StaffScheduleController::class, 'edit'])->name('edit');
                Route::put('/update/{staffSchedule}', [StaffScheduleController::class, 'update'])->name('update');
                Route::delete('/{staffSchedule}', [StaffScheduleController::class, 'destroy'])->name('destroy');
            });
        });
    });

Route::prefix('cashier')
    ->as('cashier.')
    ->middleware(['cashier'])
    ->group(function () {
        Route::match(['get', 'post'], '/', [HomeController::class, 'index'])->name('dashboard');

        Route::prefix('invoices')->as('invoices.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');

            Route::get('/create', [InvoiceController::class, 'create'])->name('create');
            Route::post('/store', [InvoiceController::class, 'store'])->name('store');

            Route::get('/detail/{invoice}', [InvoiceController::class, 'show'])->name('detail');

            Route::delete('destroy/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('report')->as('report.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
        });

        Route::get('/services', [CashierServiceController::class, 'index'])->name('services');

        Route::prefix('bookings')->as('bookings.')->group(function () {
            Route::get('/', [CashierBookingController::class, 'index'])->name('index');
            Route::get('/{booking}', [CashierBookingController::class, 'show'])->name('show');
            Route::put('/update/{booking}', [CashierBookingController::class, 'updateStatus'])->name('update');
        });
    });

Route::get('/booking', [ClientHomeController::class, 'index'])->name('choose-store');
Route::get('/booking/detail-store/{store}', [ClientStoreController::class, 'show'])->name('detail-store');
Route::get('/booking/booking-detail/{store}', [ClientBookingController::class, 'index'])->name('booking-detail');
Route::get('/booking/{booking}/success', [ClientBookingController::class, 'success'])->name('booking-success');

Route::prefix('v1')->group(function () {
    // Services
    Route::get('/services', [ClientServiceController::class, 'index']);

    // Staff
    Route::get('/staff', [ClientBookingController::class, 'getStaffs']);
    Route::get('/staff/{staff}/available-slots', [ClientBookingController::class, 'availableTimeSlots']);

    // Bookings
    Route::post('/bookings', [ClientBookingController::class, 'store']);

    Route::get('staff/{staffId}/schedule-range', [ClientBookingController::class, 'getStaffScheduleRange']);
    Route::get('/staff/{staffId}/appointments', [ClientBookingController::class, 'getAppointmentsByStaffAndDate']);
});
