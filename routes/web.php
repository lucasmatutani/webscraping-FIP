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
Route::get('/resultado/{brandSlug}/{modelSlug}/{year}', [FIPEController::class, 'showResultBySlug'])
    ->where(['brandSlug' => '[a-z0-9\-]+', 'modelSlug' => '[a-z0-9\-]+', 'year' => '[0-9\-]+'])
    ->name('resultado.slug');

Route::get('/', function () {
    return view('index');
});

Route::get('/politica-de-privacidade', function () {
    return view('politica-privacidade');
})->name('politica-privacidade');
