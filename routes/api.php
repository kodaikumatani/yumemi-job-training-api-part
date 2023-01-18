<?php

use App\Http\Controllers\GetSalesDailyController;
use App\Http\Controllers\GetSalesDailyDateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * Validation when routing receives a date.
 */
Route::pattern('date', '^([1-9][0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$');

Route::get('/sales/daily', GetSalesDailyController::class);
Route::get('/sales/daily/{date}', GetSalesDailyDateController::class);
