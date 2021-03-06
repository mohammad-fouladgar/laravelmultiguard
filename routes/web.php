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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::group(['namespace'=>'Admin','prefix'=>'admin'], function () {
    
    Route::get('/', 'AdminController@index');

    Route::group(['namespace'=>'Auth'], function () {

        Route::get('login','LoginController@showLoginForm');
        Route::post('login','LoginController@login')->name('adminlogin');
        Route::get('logout','LoginController@logout')->name('adminlogout');

    });
   
});

 