<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/hello', [ProductController::class, "index"]) ;

Route::get('/carts', [CartController::class, "index"]);

//category
Route::get('/categories', [CategoryController::class, "index"])->name('category.index');    

Route::get('/category/{id?}', [CategoryController::class, "detail"])->where('id', '[0-9]+')->name("category.detail");

Route::any( '/category/delete', [CategoryController::class, "delete"])->name('category.delete');

Route::any('/category/add', [CategoryController::class, "add"])->name('category.add');

Route::any('/category/edit', [CategoryController::class, "edit"])->name('category.edit');


//product
Route::get('/products', [ProductController::class, "index"])->name('product.index');    

Route::get('/product/{id?}', [ProductController::class, "detail"])->where('id', '[0-9]+')->name("product.detail");

Route::any('/product/delete', [ProductController::class, "delete"])->name('product.delete');

Route::any('/product/add', [ProductController::class, "add"])->name('product.add')->middleware('auth');

Route::any('/product/edit', [ProductController::class, "edit"])->name('product.edit')->middleware('auth');


//user
Route::get('/users', [UserController::class, "index"])->name('user.index');    

Route::get('/user/{id?}', [UserController::class, "detail"])->where('id', '[0-9]+')->name("user.detail");

Route::any('/user/delete', [UserController::class, "delete"])->name('user.delete');

Route::any('/user/add', [UserController::class, "add"])->name('user.add')->middleware('auth');

Route::any('/user/edit', [UserController::class, "edit"])->name('user.edit');

Route::any('/login', [UserController::class, "login"])->name('user_login');

Route::any('/logout', [UserController::class, "logout"])->name('user.logout');

// add pages about carts

