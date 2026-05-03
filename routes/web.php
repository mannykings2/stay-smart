<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ChefServiceController;
use App\Http\Controllers\DriverServiceController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PermissionAssignmentController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdVerificationController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'welcome')->name('welcome');
    Route::get('/properties', 'properties')->name('properties');
    Route::get('/invite/accept/{token}', [InvitationController::class, 'accept'])->name('invite.accept');
    Route::get('/search', 'search')->name('search');
    Route::get('/book_now', 'bookNow')->name('book_now');
    Route::get('/booking', 'booking')->name('booking');
    Route::get('/check_in', 'checkIn')->name('check_in');
    Route::get('/blog/{slug}', 'blogPost')->name('blog.show');

    Route::match(['GET', 'POST'], '/verify_payment', 'verifyPayment')->name('verify.payment');
    Route::post('/initialize_payment', 'initializePayment')->name('initialize.payment');
    Route::post('/record_failed_payment', 'recordFailedPayment')->name('record.failed.payment');
    Route::post('check_in_booking', 'checkInBooking')->name('check_in_booking')->middleware('throttle:10,1');
    Route::post('check_out_booking', 'checkOutBooking')->name('check_out_booking')->middleware('throttle:10,1');
    Route::post('contact/send', 'sendContactMessage')->name('contact.send')->middleware('throttle:5,1');
    Route::get('/api/locations', [App\Http\Controllers\LocationController::class, 'search'])->name('api.locations');
    Route::get('/receipt/{reference}', [PaymentsController::class, 'downloadReceipt'])->name('payment.receipt');
});



Route::post('/book', [PagesController::class, 'book'])->name('book');

// Apartment Registration Routes
Route::get('/register-apartment', [App\Http\Controllers\ApartmentRegistrationController::class, 'showForm'])
    ->name('register.apartment');
Route::post('/register-apartment', [App\Http\Controllers\ApartmentRegistrationController::class, 'submitForm'])
    ->name('register.apartment.submit')
    ->middleware('throttle:5,60'); // Max 5 submissions per hour

// Lease to Stay Smart Routes
Route::get('/lease-to-staysmart', [App\Http\Controllers\LeaseToStaySmartController::class, 'showForm'])
    ->name('lease.staysmart');
Route::post('/lease-to-staysmart', [App\Http\Controllers\LeaseToStaySmartController::class, 'submitForm'])
    ->name('lease.staysmart.submit')
    ->middleware('throttle:5,60'); // Max 5 submissions per hour


Auth::routes(['verify' => true]);

// Google Auth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['restrict.cleaner'])->group(function () {
        Route::controller(BookingsController::class)->group(function () {
            Route::get('/my_bookings', 'mine')->name('booking.mine');
        });
    });

    Route::controller(PagesController::class)->group(function () {
        Route::post('cancel_booking', 'cancelBooking')->name('cancel_booking');
        Route::post('/pay_now', 'payNow')->name('pay_now');
    });

    Route::controller(BookingsController::class)->group(function () {
        Route::get('/book/property/{property}', 'book')->name('booking.book');
        Route::post('/booking/store', 'store')->name('booking.store');
        Route::get('/booking/view/{reference}', 'view')->name('booking.view');
        Route::get('/api/check-availability', 'checkAvailability')->name('booking.check_availability');
    });

    Route::controller(PagesController::class)->group(function () {

        Route::get('/services', 'services')->name('service.index');

    });

    Route::controller(PropertyController::class)->group(function () {
        Route::get('/admin/properties', 'index')->name('properties.index');
        Route::middleware(['restrict.cleaner'])->group(function () {
            Route::get('/admin/properties/check-in', 'checkIn')->name('properties.checkIn');
            Route::get('/admin/properties/create', 'create')->name('properties.create');
            Route::post('/admin/properties', 'store')->name('properties.store');
        });
        Route::get('/admin/properties/{id}/amenities', 'getAmenities')->name('properties.amenities');
        Route::get('/admin/properties/all', 'allProperties')->name('properties.all');
        Route::post('/admin/properties/{id}/mark-available', 'markAsAvailable')->name('properties.markAvailable');
        Route::get('/admin/properties/{property}', 'show')->name('properties.show');
        Route::get('/admin/properties/{property}/edit', 'edit')->name('properties.edit');
        Route::put('/admin/properties/{property}', 'update')->name('properties.update');
        Route::delete('/admin/properties/{property}/images/{image}', 'deleteImage')->name('properties.images.destroy');
        Route::post('/admin/properties/{property}/bookmark', 'toggleBookmark')->name('properties.bookmark.toggle');
        Route::delete('/properties/{property}', 'destroy')->name('properties.destroy');
    });

    Route::middleware(['restrict.cleaner', 'restrict.admin.chef.driver'])->group(function () {
        Route::controller(ChefController::class)->group(function () {
            Route::get('/chefs', 'index')->name('chefs.index');
            Route::get('/chefs/create', 'create')->name('chefs.create');
            Route::post('/chefs', 'store')->name('chefs.store');
            Route::delete('/chefs/{chef}', 'destroy')->name('chefs.destroy');
            Route::get('/chefs/{chef}/services', 'getServices')->name('chefs.services');
            Route::get('/chefs/book', 'book')->name('chefs.book');
            Route::post('/chefs/book', 'storeBooking')->name('chefs.book.store');
            Route::post('/chefs/{chef}/mark-available', 'markAsAvailable')->name('chefs.markAvailable');
        });


        Route::controller(DriverController::class)->group(function () {
            Route::get('/drivers', 'index')->name('drivers.index');
            Route::get('/drivers/create', 'create')->name('drivers.create');
            Route::post('/drivers', 'store')->name('drivers.store');
            Route::get('/drivers/{driver}/edit', 'edit')->name('drivers.edit');
            Route::put('/drivers/{driver}', 'update')->name('drivers.update');
            Route::delete('/drivers/{driver}', 'destroy')->name('drivers.destroy');
            Route::get('/drivers/{driver}/services', 'getServices')->name('drivers.services');
            Route::get('/drivers/book', 'book')->name('drivers.book');
            Route::post('/drivers/book', 'storeBooking')->name('drivers.book.store');
            Route::post('/drivers/{driver}/mark-available', 'markAsAvailable')->name('drivers.markAvailable');
        });

        Route::controller(ChefServiceController::class)->group(function () {
            Route::get('/chef-service', 'index')->name('chef.service.index');
            Route::post('/chef-service', 'store')->name('chef.service.store');
            Route::put('/chef-service/{service}', 'update')->name('chef.service.update');
            Route::delete('/chef-service/{service}', 'destroy')->name('chef.service.destroy');
            Route::post('/chef-service/assign', 'assignService')->name('chef.service.assign');
        });

        Route::controller(DriverServiceController::class)->group(function () {
            Route::get('/driver-service', 'index')->name('driver.service.index');
            Route::post('/driver-service', 'store')->name('driver.service.store');
            Route::put('/driver-service/{service}', 'update')->name('driver.service.update');
            Route::delete('/driver-service/{service}', 'destroy')->name('driver.service.destroy');
            Route::post('/driver-service/assign', 'assignService')->name('driver.service.assign');
        });


        Route::controller(AmenityController::class)->group(function () {
            Route::get('/properties/amenities', 'index')->name('property.amenity.index');
            Route::post('/properties/amenities', 'store')->name('property.amenity.store');
            Route::put('/properties/amenities/{amenity}', 'update')->name('property.amenity.update');
            Route::delete('/properties/amenities/{amenity}', 'destroy')->name('property.amenity.destroy');
            Route::post('/properties/assign-amenity', 'assignAmenity')->name('property.amenity.assign');
        });
    });

    Route::middleware(['restrict.cleaner'])->group(function () {
        Route::controller(PaymentsController::class)->group(function () {
            Route::get('/payments', 'index')->name('payment.index');
            Route::get('/payments/form', 'form')->name('payment.form');
            Route::get('/payments/{id}/show', 'show')->name('payment.show');
        });

        Route::controller(BookingsController::class)->group(function () {
            Route::post('/admin/bookings/bulk-cancel', 'bulkCancelPending')->name('admin.bookings.bulk_cancel');
        });
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/update-profile', 'updateProfile')->name('update.profile');
        Route::post('/update-password', 'updatePassword')->name('update.password');
        Route::post('/set-guest-password', 'setGuestPassword')->name('guest.set-password');
    });

    Route::controller(\App\Http\Controllers\SupportTicketController::class)->group(function () {
        Route::get('/support', 'index')->name('support.index');
        Route::post('/support/submit', 'store')->name('support.store');
        Route::post('/support/{ticket}/forward', 'forward')->name('support.forward');
        Route::post('/support/{ticket}/status', 'updateStatus')->name('support.status');

        // FAQ Management
        Route::post('/support/faqs', 'storeFaq')->name('support.faqs.store');
        Route::post('/support/faqs/{faq}', 'updateFaq')->name('support.faqs.update');
        Route::delete('/support/faqs/{faq}', 'destroyFaq')->name('support.faqs.destroy');
    });

    // ID Verification - Upload (any authenticated user)
    Route::post('/profile/id-verification', [IdVerificationController::class, 'upload'])->name('id-verification.upload');

    Route::middleware(['allow.admin.superadmin'])->group(function () {
        Route::resources([
            'roles' => RolesController::class,
            'permissions' => PermissionsController::class,
            'permission-assignment' => PermissionAssignmentController::class
        ]);

        Route::controller(RoleAssignmentController::class)->group(function () {
            Route::get('/role-assignment', 'index')->name('role-assignment.index');
            Route::post('/role-assignment/store', 'store')->name('role-assignment.store');
            Route::post('/role-assignment/invite', 'invite')->name('role-assignment.invite');
            Route::delete('/role-assignment/{user}/{role}', 'destroy')->name('role-assignment.destroy');
            Route::get('/role-assignment/{user}/properties', 'getProperties')->name('role-assignment.properties');
            Route::post('/role-assignment/{user}/properties', 'syncProperties')->name('role-assignment.properties.sync');
        });

        Route::post('/invitations/generate', [InvitationController::class, 'generate'])->name('invitations.generate');
        Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
        Route::post('/role-permissions/{role}', [RolesController::class, 'getPermissions']);

        // Revenue Management (Enhanced Modules)
        Route::controller(\App\Http\Controllers\RevenueManagementController::class)->group(function () {
            Route::get('/admin/revenue', 'index')->name('admin.revenue.index');
            Route::get('/admin/revenue/transactions', 'transactions')->name('admin.revenue.transactions');
            Route::get('/admin/revenue/payouts', 'payouts')->name('admin.revenue.payouts');
            Route::get('/admin/revenue/settings', 'settings')->name('admin.revenue.settings');

            Route::post('/admin/revenue/settings/property/{property}', 'updatePropertySettings')->name('admin.revenue.settings.property');
            Route::post('/admin/revenue/settings/chef/{chef}', 'updateChefSettings')->name('admin.revenue.settings.chef');
            Route::post('/admin/revenue/settings/driver/{driver}', 'updateDriverSettings')->name('admin.revenue.settings.driver');
            Route::post('/admin/revenue/settings/update/{user}', 'updateSettings')->name('admin.revenue.settings.update');
            Route::post('/admin/revenue/payout/request', 'requestPayout')->name('admin.revenue.payout.request');
            Route::post('/admin/revenue/payout/mark-paid', 'markAsPaid')->name('admin.revenue.payout.mark_paid');
            Route::post('/admin/revenue/payout/{payout}/approve', 'approvePayout')->name('admin.revenue.payout.approve');
            Route::get('/admin/revenue/export', 'exportReport')->name('admin.revenue.export');
        });

        // Banking Details (admin payout account)
        Route::controller(\App\Http\Controllers\BankingController::class)->group(function () {
            Route::get('/admin/revenue/banking', 'index')->name('admin.revenue.banking');
            Route::post('/admin/revenue/banking', 'store')->name('admin.revenue.banking.store');
        });

        // Paystack AJAX endpoints
        Route::controller(\App\Http\Controllers\BankingController::class)->prefix('api')->group(function () {
            Route::get('/banks', 'getBanks')->name('api.banks');
            Route::get('/banks/resolve', 'resolveAccount')->name('api.banks.resolve');
        });
        // Blog Management - Super Admin Only
        Route::resource('admin/blog', \App\Http\Controllers\Admin\BlogController::class, ['names' => 'admin.blog']);

        // ID Verification Management - Super Admin Only
        Route::controller(IdVerificationController::class)->group(function () {
            Route::get('/admin/id-verification', 'index')->name('admin.id-verification.index');
            Route::get('/admin/id-verification/{verification}', 'show')->name('admin.id-verification.show');
            Route::get('/admin/id-verification/{verification}/download', 'download')->name('admin.id-verification.download');
            Route::get('/admin/id-verification/{verification}/preview', 'preview')->name('admin.id-verification.preview');
            Route::post('/admin/id-verification/{verification}/verify', 'verify')->name('admin.id-verification.verify');
            Route::post('/admin/id-verification/{verification}/reject', 'reject')->name('admin.id-verification.reject');
        });
    });


});
