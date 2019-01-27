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
Route::post('logout','Api\Auth\LoginController@logout')->middleware('auth:api');

Route::prefix('dashboard')->group(function () {
    Route::get('/sales', 'Api\DashboardController@sales')->name('dashboard.sales');
    Route::get('/financial', 'Api\DashboardController@financial')->name('dashboard.financial');
    Route::get('/orders', 'Api\DashboardController@orders')->name('dashboard.orders');
    Route::get('/clients', 'Api\DashboardController@clients')->name('dashboard.clients');
    Route::get('/budgets', 'Api\DashboardController@budgets')->name('dashboard.budgets');

});


Route::middleware('auth:api')->group(function () {


    Route::prefix('budgets')->group(function () {
        Route::get('/', 'Api\BudgetController@index');
        Route::get('/create', 'Api\BudgetController@create');
        Route::post('/', 'Api\BudgetController@store');
        Route::get('/{id}', 'Api\BudgetController@show');
        Route::get('/{id}/edit', 'Api\BudgetController@edit');
        Route::patch('/{tab}/{id}', 'Api\BudgetController@update');
        Route::delete('/{del}/{id}', 'Api\BudgetController@destroy');

        Route::get('/{type}/{id}/edit', 'Api\BudgetController@editMaterial');
        Route::patch('/{type}/{id}/update', 'Api\BudgetController@updateMaterial');
    });


    Route::prefix('orders')->group(function () {
        Route::get('/', 'Api\OrderController@index');
        Route::get('/create', 'Api\OrderController@create');
        Route::post('/', 'Api\OrderController@store');
        Route::get('/{id}', 'Api\OrderController@show');
        Route::get('/{id}/edit', 'Api\OrderController@edit');
        Route::patch('/{id}/{situacao?}', 'Api\OrderController@update');
        Route::delete('/{id}', 'Api\OrderController@destroy');
    });

    Route::prefix('pdf')->group(function () {
        Route::get('/{tipo}', 'Api\PdfController@index')->name('pdf.index');
        Route::get('/show/{tipo}/{id}', 'Api\PdfController@show')->name('pdf.show');
        Route::get('/show/{tipo}', 'Api\PdfController@showRelatorio')->name('pdf.showRelatorio');
    });


});