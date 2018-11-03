<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/sales', 'DashboardController@sales')->name('dashboard.sales');
        Route::get('/financial', 'DashboardController@financial')->name('dashboard.financial');
        Route::get('/orders', 'DashboardController@orders')->name('dashboard.orders');
        Route::get('/clients', 'DashboardController@clients')->name('dashboard.clients');
        Route::get('/budgets', 'DashboardController@budgets')->name('dashboard.budgets');

    });
//});