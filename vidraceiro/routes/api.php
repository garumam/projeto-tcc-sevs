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
Route::post('login', 'Api\Auth\LoginController@login');

//Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/sales', 'Api\DashboardController@sales')->name('dashboard.sales');
        Route::get('/financial', 'Api\DashboardController@financial')->name('dashboard.financial');
        Route::get('/orders', 'Api\DashboardController@orders')->name('dashboard.orders');
        Route::get('/clients', 'Api\DashboardController@clients')->name('dashboard.clients');
        Route::get('/budgets', 'Api\DashboardController@budgets')->name('dashboard.budgets');

    });
//});