<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\QueriesHistoryController;

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
Route::get('/get-all-countries', [CountryController::class, 'index']);
Route::get('/countries/{country}/cities', [CityController::class, 'index']);
Route::get('/currencies', [CurrencyController::class, 'index']);
Route::get('/queries_history', [QueriesHistoryController::class, 'index']);
Route::post('/save_history', [QueriesHistoryController::class, 'store']);
Route::get('/weather/{cityName}', [CityController::class, 'getWeatherByCity']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
