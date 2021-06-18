<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::group(["prefix"=>"admin"], function(){
    Route::get('/login',[App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',[App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout']);
    Route::get('/dashboard', function() {
        return view('home');
    })->name('home')->middleware('auth');

    Route::get('/products/trashList', [ProductController::class, 'trashList'])->name('products.trashList');
    Route::get('/products/restoreDeleted/{id}', [ProductController::class, 'restoreDeleted'])->name('products.restoreDeleted');
    Route::get('/products/PermanentDelete/{id}', [ProductController::class, 'permanentDelete'])->name('products.permanentDelete');
    Route::resource('products', ProductController::class);

    Route::get('/categories/trashList', [CategoryController::class, 'trashList'])->name('categories.trashList');
    Route::get('/categories/restoreDeleted/{id}', [CategoryController::class, 'restoreDeleted'])->name('categories.restoreDeleted');
    Route::get('/categories/PermanentDelete/{id}', [CategoryController::class, 'PermanentDelete'])->name('categories.PermanentDelete');
    Route::resource('categories', CategoryController::class);
});
