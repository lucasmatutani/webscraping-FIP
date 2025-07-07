<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FIPEController;

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

Route::get('/api/brands', [FipeController::class, 'getBrands']);
Route::get('/api/models/{brandId}', [FipeController::class, 'getModels']);
Route::get('/api/years/{modelId}', [FipeController::class, 'getYears']);
Route::get('/api/value', [FipeController::class, 'getCarValue']);

Route::get('/', function () {
    return view('index');
});
