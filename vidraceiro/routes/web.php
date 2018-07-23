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
Route::get('/create/user','UserController@index')->name('createUser');
Route::post('/create/user','UserController@create');
Route::get('/update/user/{id}','UserController@edit')->name('updateUser');
Route::post('/update/user/{id}','UserController@update');
Route::post('/delete/user/{id}','UserController@delete')->name('deleteUser');
Route::get('/read/user','UserController@read')->name('listUser');



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



