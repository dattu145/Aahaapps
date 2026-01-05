<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/{slug}', [PublicController::class, 'show'])->where('slug', '^(?!admin|login|register|logout).*$')->name('page.show');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CMS Routes
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);


    Route::post('home-page-cards/update-dimensions', [\App\Http\Controllers\Admin\CircularItemController::class, 'updateDimensions'])->name('home-page-cards.update-dimensions');
    Route::resource('home-page-cards', \App\Http\Controllers\Admin\CircularItemController::class)->parameters(['home-page-cards' => 'circular_item']);
});

require __DIR__.'/auth.php';
