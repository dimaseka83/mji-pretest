<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\InventoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [HomeController::class, 'authenticate']);
Route::post('/logout', [HomeController::class, 'logout']);

Route::get('/inventory', [InventoryController::class, 'inventory']);
Route::post('/add-inventory', [InventoryController::class, 'addInventory']);
Route::delete('/delete-inventory/{id}', [InventoryController::class, 'deleteInventory']);

Route::post('/add-penjualan', [InventoryController::class, 'addPenjualan']);
Route::post('/add-pembelian', [InventoryController::class, 'addPembelian']);

