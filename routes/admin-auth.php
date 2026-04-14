<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\UserListingController;

Route::prefix('admin')->middleware(['auth:admin', 'admin.permission'])->group(function () {

    Route::get('user-listings', [UserListingController::class, 'index'])
        ->name('admin.user-listings.index');

    Route::post('user-listings/{listing}/approve',
        [UserListingController::class, 'approve'])
        ->name('admin.user-listings.approve');

    Route::post('user-listings/{listing}/reject',
        [UserListingController::class, 'reject'])
        ->name('admin.user-listings.reject');

});



Route::post(
    '/properties/{id}/duplicate',
    [PropertyController::class, 'duplicate']
)->name('admin.properties.duplicate');

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('admin.login');

    Route::post('login', [LoginController::class, 'store']);

});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])
        ->name('admin.logout');
});

Route::prefix('admin')->middleware(['auth:admin', 'admin.permission'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/property-list', [PropertyController::class, 'index'])->name('admin.property-list');

    Route::put('properties/{property}/toggle-verified', [PropertyController::class, 'toggleVerified'])->name('admin.properties.toggleVerified');

    Route::get('properties/{id}/edit', [PropertyController::class, 'edit'])->name('admin.properties.edit');
    Route::put('properties/{property}', [PropertyController::class, 'update'])->name('admin.properties.update');

    Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('admin.properties.destroy');

    Route::delete('properties/images/{picture}', [PropertyController::class, 'deleteImage'])->name('admin.property.image.delete');

    Route::resource('amenities', \App\Http\Controllers\Admin\AmenityController::class)->names('admin.amenities');

    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class)->names('admin.transactions');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users')->except(['show', 'create', 'store']);
    Route::put('users/{user}/toggle-suspend', [\App\Http\Controllers\Admin\UserController::class, 'toggleSuspend'])->name('admin.users.toggleSuspend');

    Route::get('notifications', [DashboardController::class, 'notifications'])->name('admin.notifications');

    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->names('admin.banners')->except(['show']);

    Route::resource('featured-sections', \App\Http\Controllers\Admin\FeaturedSectionController::class)->names('admin.featured-sections')->except(['show']);
    Route::resource('home-cta-sections', \App\Http\Controllers\Admin\HomeCtaSectionController::class)->names('admin.home-cta-sections')->except(['show']);
    Route::put('home-cta-sections/{id}/toggle-active', [\App\Http\Controllers\Admin\HomeCtaSectionController::class, 'toggleActive'])->name('admin.home-cta-sections.toggleActive');
    Route::resource('home-verified-sections', \App\Http\Controllers\Admin\HomeVerifiedSectionController::class)->names('admin.home-verified-sections')->except(['index', 'show']);
    Route::put('home-verified-sections/{id}/toggle-active', [\App\Http\Controllers\Admin\HomeVerifiedSectionController::class, 'toggleActive'])->name('admin.home-verified-sections.toggleActive');
    Route::resource('home-why-sections', \App\Http\Controllers\Admin\HomeWhySectionController::class)->names('admin.home-why-sections')->except(['index', 'show']);
    Route::put('home-why-sections/{id}/toggle-active', [\App\Http\Controllers\Admin\HomeWhySectionController::class, 'toggleActive'])->name('admin.home-why-sections.toggleActive');
    Route::resource('home-sales-sections', \App\Http\Controllers\Admin\HomeSalesSectionController::class)->names('admin.home-sales-sections')->except(['index', 'show']);
    Route::put('home-sales-sections/{id}/toggle-active', [\App\Http\Controllers\Admin\HomeSalesSectionController::class, 'toggleActive'])->name('admin.home-sales-sections.toggleActive');

    Route::resource('admin-users', \App\Http\Controllers\Admin\AdminUserController::class)->names('admin.admin-users')->except(['show']);
    Route::put('admin-users/{id}/toggle-active', [\App\Http\Controllers\Admin\AdminUserController::class, 'toggleActive'])->name('admin.admin-users.toggleActive');
});
