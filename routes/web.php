<?php

use App\Http\Controllers\controller1;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;


//kode baru diubah menjadi seperti ini
Route::get('/',[HomepageController::class,'index']);
Route::get('products', [HomepageController::class, 'products']);
Route::get('products/{slug}', [HomepageController::class, 'single_product']);
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'single_category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'showProducts']);
Route::get('/navbar', [HomepageController::class, 'navbarCategories']);


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route untuk kategori
    Route::resource('categories', ProductCategoryController::class);
    Route::get('products',[DashboardController::class,'products'])->name('products');
    // Route resource untuk produk
    Route::resource('products', ProductController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



require __DIR__.'/auth.php';
