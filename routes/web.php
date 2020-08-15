<?php

use Illuminate\Support\Facades\Route;

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

// Chat route
Route::get('/', function(){
    return view('pages.main');
});

// Authentication routes
Route::get('another', function(){
    return 'another route';
});

Route::get('login', function(){
   return 'login_page';
});

//Route::get('/login', 'AuthController@showLogin')->name('login')->middleware('guest');
Route::post('/logout', 'AuthController@logout')->name('logout');

// api messages
Route::group(['prefix' => 'api/v1'], function(){
    // Authetication
    Route::group(['prefix' => '/auth'], function(){
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');
        Route::post('/logout', 'AuthController@logout');
    });

    Route::resource('/message', 'ChatController')->except(['edit', 'create']);
});
