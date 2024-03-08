<?php


use App\Http\Controllers\Api\Dashboard\AuthController;
use App\Http\Controllers\Api\Dashboard\CompanyController;
use App\Http\Controllers\Api\Dashboard\MedicineController;
use App\Http\Controllers\Api\Dashboard\MedicineDetailsController;
use App\Http\Controllers\Api\Dashboard\OrderController;
use App\Http\Controllers\Api\Dashboard\PharmacistController;
use App\Http\Controllers\Api\Dashboard\CategoryController;
use App\Http\Controllers\Api\Dashboard\InvoiceController;
use Illuminate\Support\Facades\Route;



Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // For Medicines
    Route::post('medicine', [MedicineController::class, 'store']); //add medicine <> --done
 /**/   Route::get('medicine/{medicine}', [MedicineController::class, 'show']); //get one medicine
 /**/   Route::post('medicine/{medicine}/doses', [MedicineDetailsController::class, 'store']); //add medicine dose
 /**/   Route::put('medicine/{medicine}/doses/{dose}/quantity', [MedicineDetailsController::class, 'updateQuantity']);
 /**/   Route::put('medicine/{medicine}/doses/{dose}/price', [MedicineDetailsController::class, 'updatePrice']);
 /**/   Route::get('medicine/{medicine}/doses', [MedicineDetailsController::class, 'index']); //get medicine doses
 /**/   Route::delete('medicine/{medicine}/doses/{dose}', [MedicineDetailsController::class, 'destroy']); //delete dose
 /**/   Route::delete('medicine/{medicine}', [MedicineController::class, 'destroy']); //delete dose
    Route::get('medicines', [MedicineController::class, 'index']); //get all warehouse medicines
    Route::get('medicine', [MedicineController::class, 'search']); //search medicine <> --done
 /**/   Route::get('medicine/{medicine}/doses/expired', [MedicineController::class, 'expired']); //add medicine dose

    // No need
    Route::get('pharmacists', [PharmacistController::class, 'index']); //get all pharmacist details

    // For Categories
    Route::get('categories', [CategoryController::class, 'index']); //get all categories
  /**/  Route::get('category/{category}/medicines', [CategoryController::class, 'getMedicines']); //get all categories medicines <> --done

    // For Companies
  /**/  Route::get('companies/{company}/medicines', [CompanyController::class, 'getMedicines']); //get all companies medicines <>
    Route::get('companies', [CompanyController::class, 'index']); // get all companies <> --done
  /**/  Route::get('companies/{company}', [CompanyController::class, 'show']); // get specific company
    Route::post('invoice', [InvoiceController::class, 'createInvoice']); // invoice (change)

    // For Orders
    Route::get('orders', [OrderController::class, 'index']);  // get all orders
    Route::get('orders/rejected', [OrderController::class, 'rejectedOrders']);  // get all orders
 /**/   Route::get('order/{order}', [OrderController::class, 'show']);  // get order details
 /**/   Route::put('order/{order}/status', [OrderController::class, 'changeStatus']);  // change order status
 /**/   Route::put('order/{order}/payment', [OrderController::class, 'changePaymentStatus']); // change payment status
 /**/   Route::post('order/{order}/order-status', [OrderController::class, 'changeOrderStatus']); // change order status
 /**/   Route::post('order/{order}/check', [OrderController::class, 'checkPossibility']); // check possibility
// });
