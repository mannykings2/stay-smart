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
    Route::post('check_in_booking', 'checkInBooking')->name('check_in_booking')->middleware('throttle:10,1');
    Route::post('check_out_booking', 'checkOutBooking')->name('check_out_booking')->middleware('throttle:10,1');
    Route::get('/api/locations', [App\Http\Controllers\LocationController::class, 'search'])->name('api.locations');
});


// Route::get('/check_in', [PagesController::class, 'checkIn'])->name('check_in');

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
            //Route::post('/checkin/{id}', 'checkIn')->name('checkin');
            //Route::post('/checkout/{id}', 'checkOut')->name('checkout');
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
        Route::post('contact/send', 'sendContactMessage')->name('contact.send');
        Route::get('/services', 'services')->name('service.index');
        Route::post('pay_now', 'payNow')->name('pay_now');

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
            Route::delete('/drivers/{driver}', 'destroy')->name('drivers.destroy');
            Route::get('/drivers/{driver}/services', 'getServices')->name('drivers.services');
            Route::get('/drivers/book', 'book')->name('drivers.book');
            Route::post('/drivers/book', 'storeBooking')->name('drivers.book.store');
            Route::post('/drivers/{driver}/mark-available', 'markAsAvailable')->name('drivers.markAvailable');
        });

        Route::controller(ChefServiceController::class)->group(function () {
            Route::get('/chef-service', 'index')->name('chef.service.index');
            Route::post('/chef-service', 'store')->name('chef.service.store');
            Route::post('/chef-service/assign', 'assignService')->name('chef.service.assign');
        });

        Route::controller(DriverServiceController::class)->group(function () {
            Route::get('/driver-service', 'index')->name('driver.service.index');
            Route::post('/driver-service', 'store')->name('driver.service.store');
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
        });
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/update-profile', 'updateProfile')->name('update.profile');
        Route::post('/update-password', 'updatePassword')->name('update.password');
        Route::post('/set-guest-password', 'setGuestPassword')->name('guest.set-password');
    });

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
        });

        Route::post('/invitations/generate', [InvitationController::class, 'generate'])->name('invitations.generate');
        Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
        Route::post('/role-permissions/{role}', [RolesController::class, 'getPermissions']);
    });
    // Blog Management - Super Admin Only
    Route::resource('admin/blog', \App\Http\Controllers\Admin\BlogController::class, ['names' => 'admin.blog']);

});
