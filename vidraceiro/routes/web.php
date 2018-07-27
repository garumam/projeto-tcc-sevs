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
Route::get('/products','ProductController@index')->name('product.index');
Route::get('/products/create','ProductController@create')->name('product.create');
Route::post('/products/create','ProductController@create')->name('product.create');


//rotas de categoria
Route::get('/categories','CategoryController@index')->name('category.index');
Route::get('/categories/create','CategoryController@create')->name('category.create');
Route::post('/categories/create','CategoryController@create')->name('category.create');




//rotas dos materiais
Route::get('/materials','UserController@index')->name('materials.index');
Route::get('/materials/create','UserController@create')->name('materials.create');
Route::post('/materials','UserController@store')->name('materials.store');
Route::get('/materials/{user}','UserController@show')->name('materials.show');
Route::get('/materials/{id}/edit','UserController@edit')->name('materials.edit');
Route::patch('/materials/{id}','UserController@update')->name('materials.update');
Route::delete('/materials/{id}','UserController@destroy')->name('materials.destroy');




//rotas dos orçamentos
Route::get('/budgets','UserController@index')->name('budgets.index');
Route::get('/budgets/create','UserController@create')->name('budgets.create');
Route::post('/budgets','UserController@store')->name('budgets.store');
Route::get('/budgets/{user}','UserController@show')->name('budgets.show');
Route::get('/budgets/{id}/edit','UserController@edit')->name('budgets.edit');
Route::patch('/budgets/{id}','UserController@update')->name('budgets.update');
Route::delete('/budgets/{id}','UserController@destroy')->name('budgets.destroy');


//rotas das ordens de serviço
Route::get('/orders','UserController@index')->name('orders.index');
Route::get('/orders/create','UserController@create')->name('orders.create');
Route::post('/orders','UserController@store')->name('orders.store');
Route::get('/orders/{user}','UserController@show')->name('orders.show');
Route::get('/orders/{id}/edit','UserController@edit')->name('orders.edit');
Route::patch('/orders/{id}','UserController@update')->name('orders.update');
Route::delete('/orders/{id}','UserController@destroy')->name('orders.destroy');

//rotas das fornecedores
Route::get('/providers','UserController@index')->name('providers.index');
Route::get('/providers/create','UserController@create')->name('providers.create');
Route::post('/providers','UserController@store')->name('providers.store');
Route::get('/providers/{user}','UserController@show')->name('providers.show');
Route::get('/providers/{id}/edit','UserController@edit')->name('providers.edit');
Route::patch('/providers/{id}','UserController@update')->name('providers.update');
Route::delete('/providers/{id}','UserController@destroy')->name('providers.destroy');


//rotas da empresa
Route::get('/companies','UserController@index')->name('companies.index');
Route::get('/companies/create','UserController@create')->name('companies.create');
Route::post('/companies','UserController@store')->name('companies.store');
Route::get('/companies/{user}','UserController@show')->name('companies.show');
Route::get('/companies/{id}/edit','UserController@edit')->name('companies.edit');
Route::patch('/companies/{id}','UserController@update')->name('companies.update');
Route::delete('/companies/{id}','UserController@destroy')->name('companies.destroy');


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



