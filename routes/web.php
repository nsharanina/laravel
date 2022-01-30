<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return redirect()->route('home');
})->name('main');

Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/exportCategories', [CategoryController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/importCategories', [CategoryController::class, 'importCategories'])->name('importCategories');
    Route::get('/profile', [HomeController::class, 'profile'])->middleware('auth')->name('profile');
    Route::post('/profile/update', [HomeController::class, 'profileUpdate'])->name('profileUpdate');
    Route::post('addCategory', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/orders', [HomeController::class, 'index'])->name('orders');

});

Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket');
    Route::post('/createOrder', [BasketController::class, 'createOrder'])->name('createOrder');
    Route::post('/add', [BasketController::class, 'add'])->name('addProduct');
    Route::post('/remove', [BasketController::class, 'remove'])->name('removeProduct');
       
    
});

Route::get('/orders', [OrderController::class, 'index'])->name('orders');

// Route::any('/{any}', function () {
//     return redirect(route('main'));
// })->where('any', '.*');

Auth::routes();

Route::get('/categories/{category}', [CategoryController::class, 'category'])->name('category');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

Route::prefix('admin')->middleware(['auth', 'role'])->group(function () {

    //Route::redirect('/', '/admin/products');

    /*
    Route::get('/', function () {
        return redirect(route('adminProducts'));
    });
     */
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/enterAsUser/{userId}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::get('/products', [ProductController::class, 'products'])->name('products');
    Route::post('newProduct', [ProductController::class, 'newProduct'])->name('newProduct');
    Route::post('/exportProducts', [ProductController::class, 'exportProducts'])->name('exportProducts');
    Route::post('/importProducts', [ProductController::class, 'importProducts'])->name('importProducts');
    Route::get('/categories', function() {
        return redirect()->route('home');
        })->name('main');;
    Route::get('/users', [AdminController::class, 'usersList'])->name('users');
});