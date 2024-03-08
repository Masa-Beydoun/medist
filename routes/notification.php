<?php

use Illuminate\Support\Facades\Route;

Route::get('/confirmOrder',[NotificationController::class,'confirmOrder']);
