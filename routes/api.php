<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::resource('/category-product', CategoryProductController::class);
Route::resource('/images', ImageController::class);
Route::post('/images-update/{id}', 'App\Http\Controllers\ImageController@update');
Route::resource('/images-product', ProductImageController::class);

