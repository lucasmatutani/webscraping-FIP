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

Route::get('/api/brands', [FIPEController::class, 'getBrands']);
Route::get('/api/models/{brandId}', [FIPEController::class, 'getModels']);
Route::get('/api/years/{modelId}', [FIPEController::class, 'getYears']);
Route::get('/api/value', [FIPEController::class, 'getCarValue']);

Route::get('/resultado', [FIPEController::class, 'showResult'])->name('resultado');

Route::get('/', function () {
    return view('index');
});
