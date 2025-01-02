<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CryptTransactionController;



Route::get('/api/coins', [CoinController::class, 'index']);
Route::get('/api/vendors', [VendorController::class, 'index']);
Route::post('/api/confirm-payment', [CryptTransactionController::class, 'store']);
