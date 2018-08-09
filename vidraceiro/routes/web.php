<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/list', 'DashboardController@list')->name('list');


//rotas do usuario
Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::get('/create', 'UserController@create')->name('users.create');
    Route::post('/', 'UserController@store')->name('users.store');
    Route::get('/{user}', 'UserController@show')->name('users.show');
    Route::get('/{id}/edit', 'UserController@edit')->name('users.edit');
    Route::patch('/{id}', 'UserController@update')->name('users.update');
    Route::delete('/{id}', 'UserController@destroy')->name('users.destroy');
});

//rotas de produto
Route::prefix('products')->group(function () {
    Route::get('/', 'MProductController@index')->name('products.index');
    Route::get('/create', 'MProductController@create')->name('products.create');
    Route::post('/', 'MProductController@store')->name('products.store');
    Route::get('/{user}', 'MProductController@show')->name('products.show');
    Route::get('/{id}/edit', 'MProductController@edit')->name('products.edit');
    Route::patch('/{id}', 'MProductController@update')->name('products.update');
    Route::delete('/{id}', 'MProductController@destroy')->name('products.destroy');
});

//rotas de categoria
Route::prefix('categories')->group(function () {
    Route::get('/', 'CategoryController@index')->name('categories.index');
    Route::get('/create', 'CategoryController@create')->name('categories.create');
    Route::post('/', 'CategoryController@store')->name('categories.store');
    Route::get('/{user}', 'CategoryController@show')->name('categories.show');
    Route::get('/{id}/edit', 'CategoryController@edit')->name('categories.edit');
    Route::patch('/{id}', 'CategoryController@update')->name('categories.update');
    Route::delete('/{id}', 'CategoryController@destroy')->name('categories.destroy');
});

//rotas dos materiais
Route::prefix('materials')->group(function () {
    Route::get('/', 'MaterialController@index')->name('materials.index');
    Route::get('/{type}/create', 'MaterialController@create')->name('materials.create');
    Route::post('/{type}', 'MaterialController@store')->name('materials.store');
    Route::get('/{user}', 'MaterialController@show')->name('materials.show');
    Route::get('/{type}/{id}/edit', 'MaterialController@edit')->name('materials.edit');
    Route::patch('/{type}/{id}', 'MaterialController@update')->name('materials.update');
    Route::delete('/{type}/{id}', 'MaterialController@destroy')->name('materials.destroy');
});

//rotas dos orçamentos
Route::prefix('budgets')->group(function () {
    Route::get('/', 'BudgetController@index')->name('budgets.index');
    Route::get('/create', 'BudgetController@create')->name('budgets.create');
    Route::post('/', 'BudgetController@store')->name('budgets.store');
    Route::get('/{user}', 'BudgetController@show')->name('budgets.show');
    Route::get('/{id}/edit', 'BudgetController@edit')->name('budgets.edit');
    Route::patch('/{id}', 'BudgetController@update')->name('budgets.update');
    Route::delete('/{id}', 'BudgetController@destroy')->name('budgets.destroy');
});

//rotas das ordens de serviço
Route::prefix('orders')->group(function () {
    Route::get('/', 'OrderController@index')->name('orders.index');
    Route::get('/create', 'OrderController@create')->name('orders.create');
    Route::post('/', 'OrderController@store')->name('orders.store');
    Route::get('/{user}', 'OrderController@show')->name('orders.show');
    Route::get('/{id}/edit', 'OrderController@edit')->name('orders.edit');
    Route::patch('/{id}', 'OrderController@update')->name('orders.update');
    Route::delete('/{id}', 'OrderController@destroy')->name('orders.destroy');
});

//rotas das fornecedores
Route::prefix('providers')->group(function () {
    Route::get('/', 'ProviderController@index')->name('providers.index');
    Route::get('/create', 'ProviderController@create')->name('providers.create');
    Route::post('/', 'ProviderController@store')->name('providers.store');
    Route::get('/{user}', 'ProviderController@show')->name('providers.show');
    Route::get('/{id}/edit', 'ProviderController@edit')->name('providers.edit');
    Route::patch('/{id}', 'ProviderController@update')->name('providers.update');
    Route::delete('/{id}', 'ProviderController@destroy')->name('providers.destroy');
});

//rotas da empresa
Route::prefix('companies')->group(function () {
    Route::get('/', 'CompanyController@index')->name('companies.index');
    Route::get('/create', 'CompanyController@create')->name('companies.create');
    Route::post('/', 'CompanyController@store')->name('companies.store');
    Route::get('/{user}', 'CompanyController@show')->name('companies.show');
    Route::get('/{id}/edit', 'CompanyController@edit')->name('companies.edit');
    Route::patch('/{id}', 'CompanyController@update')->name('companies.update');
    Route::delete('/{id}', 'CompanyController@destroy')->name('companies.destroy');
});

//rotas da gerar pdf
Route::prefix('pdf')->group(function () {
    Route::get('/', 'PdfController@index')->name('pdf.index');
    Route::get('/create', 'PdfController@create')->name('pdf.create');
    Route::post('/', 'PdfController@store')->name('pdf.store');
    Route::get('/{user}', 'PdfController@show')->name('pdf.show');
    Route::get('/{id}/edit', 'PdfController@edit')->name('pdf.edit');
    Route::patch('/{id}', 'PdfController@update')->name('pdf.update');
    Route::delete('/{id}', 'PdfController@destroy')->name('pdf.destroy');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');



