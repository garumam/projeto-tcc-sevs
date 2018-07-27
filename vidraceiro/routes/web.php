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
Route::get('/product','ProductController@index')->name('product.index');
Route::get('/product/create','ProductController@create')->name('product.create');
Route::post('/product/create','ProductController@create')->name('product.create');


//rotas de categoria
Route::get('/category','CategoryController@index')->name('category.index');
Route::get('/category/create','CategoryController@create')->name('category.create');
Route::post('/product/create','CategoryController@create')->name('category.create');


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



