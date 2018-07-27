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
Route::get('/list','DashboardController@list')->name('list');



//rotas do usuario
Route::get('/users','UserController@index')->name('users.index');
Route::get('/users/create','UserController@create')->name('users.create');
Route::post('/users','UserController@store')->name('users.store');
Route::get('/users/{user}','UserController@show')->name('users.show');
Route::get('/users/{id}/edit','UserController@edit')->name('users.edit');
Route::patch('/users/{id}','UserController@update')->name('users.update');
Route::delete('/users/{id}','UserController@destroy')->name('users.destroy');

//rotas de produto
Route::get('/products','ProductController@index')->name('products.index');
Route::get('/products/create','ProductController@create')->name('products.create');
Route::post('/products','ProductController@store')->name('products.store');
Route::get('/products/{user}','ProductController@show')->name('products.show');
Route::get('/products/{id}/edit','ProductController@edit')->name('products.edit');
Route::patch('/products/{id}','ProductController@update')->name('products.update');
Route::delete('/products/{id}','ProductController@destroy')->name('products.destroy');


//rotas de categoria

Route::get('/categories','CategoryController@index')->name('categories.index');
Route::get('/categories/create','CategoryController@create')->name('categories.create');
Route::post('/categories','CategoryController@store')->name('categories.store');
Route::get('/categories/{user}','CategoryController@show')->name('categories.show');
Route::get('/categories/{id}/edit','CategoryController@edit')->name('categories.edit');
Route::patch('/categories/{id}','CategoryController@update')->name('categories.update');
Route::delete('/categories/{id}','CategoryController@destroy')->name('categories.destroy');


//rotas dos materiais
Route::get('/materials','MaterialController@index')->name('materials.index');
Route::get('/materials/create','MaterialController@create')->name('materials.create');
Route::post('/materials','MaterialController@store')->name('materials.store');
Route::get('/materials/{user}','MaterialController@show')->name('materials.show');
Route::get('/materials/{id}/edit','MaterialController@edit')->name('materials.edit');
Route::patch('/materials/{id}','MaterialController@update')->name('materials.update');
Route::delete('/materials/{id}','MaterialController@destroy')->name('materials.destroy');




//rotas dos orçamentos
Route::get('/budgets','BudgetController@index')->name('budgets.index');
Route::get('/budgets/create','BudgetController@create')->name('budgets.create');
Route::post('/budgets','BudgetController@store')->name('budgets.store');
Route::get('/budgets/{user}','BudgetController@show')->name('budgets.show');
Route::get('/budgets/{id}/edit','BudgetController@edit')->name('budgets.edit');
Route::patch('/budgets/{id}','BudgetController@update')->name('budgets.update');
Route::delete('/budgets/{id}','BudgetController@destroy')->name('budgets.destroy');


//rotas das ordens de serviço
Route::get('/orders','OrderController@index')->name('orders.index');
Route::get('/orders/create','OrderController@create')->name('orders.create');
Route::post('/orders','OrderController@store')->name('orders.store');
Route::get('/orders/{user}','OrderController@show')->name('orders.show');
Route::get('/orders/{id}/edit','OrderController@edit')->name('orders.edit');
Route::patch('/orders/{id}','OrderController@update')->name('orders.update');
Route::delete('/orders/{id}','OrderController@destroy')->name('orders.destroy');

//rotas das fornecedores
Route::get('/providers','ProviderController@index')->name('providers.index');
Route::get('/providers/create','ProviderController@create')->name('providers.create');
Route::post('/providers','ProviderController@store')->name('providers.store');
Route::get('/providers/{user}','ProviderController@show')->name('providers.show');
Route::get('/providers/{id}/edit','ProviderController@edit')->name('providers.edit');
Route::patch('/providers/{id}','ProviderController@update')->name('providers.update');
Route::delete('/providers/{id}','ProviderController@destroy')->name('providers.destroy');


//rotas da empresa
Route::get('/companies','CompanyController@index')->name('companies.index');
Route::get('/companies/create','CompanyController@create')->name('companies.create');
Route::post('/companies','CompanyController@store')->name('companies.store');
Route::get('/companies/{user}','CompanyController@show')->name('companies.show');
Route::get('/companies/{id}/edit','CompanyController@edit')->name('companies.edit');
Route::patch('/companies/{id}','CompanyController@update')->name('companies.update');
Route::delete('/companies/{id}','CompanyController@destroy')->name('companies.destroy');


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



