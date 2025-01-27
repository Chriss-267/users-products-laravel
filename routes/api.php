<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function (){
    Route::post('/logout', [AuthController::class, "logout"]);
});

Route::post('/register', [AuthController::class, "registro"]);

Route::post('/login', [AuthController::class, "login"]);

//rutas de orders
Route::get('orders/show',[OrderController::class, "index"]);
Route::post('orders/create',[OrderController::class, "store"]);
Route::patch('orders/update/{id}',[OrderController::class, "update"]);
Route::delete('orders/delete/{id}',[OrderController::class, "destroy"]);

//ruts de products
Route::get('products/show',[ProductController::class, "index"]);
Route::post('products/create',[ProductController::class, "store"]);
Route::patch('products/update/{id}',[ProductController::class, "update"]);
Route::delete('products/delete/{id}',[ProductController::class, "destroy"]);

//rutas de distributor
Route::get('distributors/show',[DistributorController::class, "index"]);
Route::post('distributors/create',[DistributorController::class, "store"]);
Route::patch('distributors/update/{id}',[DistributorController::class, "update"]);
Route::delete('distributors/delete/{id}',[DistributorController::class, "destroy"]);

//rutas product-categories
Route::get('product-categories/show',[ProductCategoryController::class, "index"]);
Route::post('product-categories/create',[ProductCategoryController::class, "store"]);
Route::patch('product-categories/update/{id}',[ProductCategoryController::class, "update"]);
Route::delete('product-categories/delete/{id}',[ProductCategoryController::class, "destroy"]);

//rutas orders_details
Route::get('orders-details/show',[OrderDetailsController ::class, "index"]);
Route::post('orders-details/create',[OrderDetailsController::class, "store"]);
Route::patch('orders-details/update/{id}',[OrderDetailsController::class, "update"]);
Route::delete('orders-details/delete/{id}',[OrderDetailsController::class, "destroy"]);

