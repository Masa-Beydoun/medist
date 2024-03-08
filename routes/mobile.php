<?php

use App\Http\Controllers\Api\Mobile\AddressController;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Mobile\CategoryController;
use App\Http\Controllers\Api\Mobile\PharmacistController;
use App\Http\Controllers\Api\Mobile\SettingController;
use App\Http\Controllers\Api\Mobile\CompanyController;
use App\Http\Controllers\Api\Mobile\MedicineController;
use App\Http\Controllers\Api\Mobile\QuantityController;
use App\Http\Controllers\Api\Mobile\FavoriteController;
use App\Http\Controllers\Api\Mobile\OrderController;
use App\Http\Controllers\Api\Mobile\InvoiceController;

use Illuminate\Support\Facades\Route;

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

// Start Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
// End Auth

// Route::middleware('auth:sanctum')->group(function () {
    //Auth
    Route::post('logout', [AuthController::class, 'logout']);

    // Pharmacist Details and Settings
    Route::put('pharmacist/data', [PharmacistController::class, 'updateData']); //update pharmacist details
    Route::get('pharmacist/data', [PharmacistController::class, 'showDetails']); //get pharmacist details
    Route::put('pharmacist/address', [AddressController::class, 'updateData']); // update pharmacist address
    Route::put('pharmacist/settings', [SettingController::class, 'updateData']); // update pharmacist settings

    // Company
    Route::get('companies', [CompanyController::class, 'index']); // get all companies <> --done
    Route::get('companies/{company}/medicines', [CompanyController::class, 'getMedicines']); // get specific company medicines

    // Medicine
    Route::get('medicine', [MedicineController::class, 'search']); //search medicine<> --done
    Route::get('medicines', [MedicineController::class, 'index']); //get all medicines <> --done
    Route::get('medicine/{medicine}', [MedicineController::class, 'show']); //get medicine details

    // Favorites
    Route::post('pharmacist/favorites', [FavoriteController::class, 'addFavorites']); //add to favorites
    Route::get('pharmacist/favorites', [FavoriteController::class, 'getFavorites']); //get all favorites
    Route::delete('pharmacist/favorites/{id}', [FavoriteController::class, 'removeFromFavorites']); //remove from favorites

    // Orders
    Route::post('pharmacist/order/finish', [OrderController::class, 'addOrder2']); // buy order <> --done
    Route::get('pharmacist/orders', [OrderController::class, 'getOrders']); // get all orders <> --done
    Route::get('pharmacist/orders/last', [OrderController::class, 'getLatestOrder']); // get latest order <> --done
    Route::get('pharmacist/orders/prepared', [OrderController::class, 'getOrdersBeingPrepared']);  // get orders not delivered
    Route::get('pharmacist/orders/{order}', [OrderController::class, 'getOneOrder']); // get specific order

    Route::get('most-sold', [QuantityController::class, 'mostSold']);  // get most sold <> --done

    // Category
    Route::get('category/{category}/medicines', [CategoryController::class, 'getMedicines']); // get medicines in one category <> --done
    Route::get('category', [CategoryController::class, 'search']);  // search category get category
    Route::get('categories', [CategoryController::class, 'index']); //get all categories

    // Invoice
    Route::post('invoice', [InvoiceController::class, 'createInvoice']);
// });

