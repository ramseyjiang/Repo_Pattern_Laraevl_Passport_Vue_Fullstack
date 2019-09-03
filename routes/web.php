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

Auth::routes();

Route::group([ 'prefix' => 'blogs' ], function ($router) {
    Route::get('/index', 'BlogController@index')->name('blogs.index');
    Route::get('/show/{blogId}', 'BlogController@show')->name('blogs.show');
    Route::post('/store', 'BlogController@store')->name('blogs.store');
    Route::put('/update/{blogId}', 'BlogController@update')->name('blogs.update');
    Route::delete('/delete/{blogId}', 'BlogController@destroy')->name('blogs.destroy');
});

Route::get('/{any?}', function () {
    return view('welcome');
});
