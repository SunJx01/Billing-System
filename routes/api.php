<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// ...
 
Route::apiResource('companies', CompanyController::class);

Route::post('/login', [ApiController::class, 'login'])->name('login');
Route::post('/check',ApiController::class,'check');

