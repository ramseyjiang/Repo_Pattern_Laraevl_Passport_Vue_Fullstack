<?php

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
Route::group(['middleware' => 'api'], function () {
    Route::post('register', 'Api\UserController@register');
    Route::post('login', 'Api\UserController@login');

    Route::group([ 'prefix' => 'blogs' ], function () {
        Route::get('/index', 'Api\BlogController@index')->name('blogs.index');
        Route::get('/show/{blogId}', 'Api\BlogController@show')->name('blogs.show');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    // dd(auth()->guard('api')->check());
    Route::get('user', 'Api\UserController@user');
    Route::get('logout', 'Api\UserController@logout');

    Route::group([ 'prefix' => 'blogs' ], function () {
        Route::post('/store', 'Api\BlogController@store')->name('blogs.store');
        Route::put('/update/{blogId}', 'Api\BlogController@update')->name('blogs.update');
        Route::delete('/delete/{blogId}', 'Api\BlogController@destroy')->name('blogs.destroy');
    });

    Route::group([ 'prefix' => 'tasks' ], function () {
        Route::post('/store', 'Api\TaskController@store')->name('tasks.store');
        Route::put('/update/{taskId}', 'Api\TaskController@update')->name('tasks.update');
        Route::post('/showActiveTasks', 'Api\TaskController@showActiveTasks')->name('tasks.showActiveTasks');
        Route::post('/showFinishedTasks', 'Api\TaskController@showFinishedTasks')->name('tasks.showFinishedTasks');
        Route::post('/showTrashedTasks', 'Api\TaskController@showTrashedTasks')->name('tasks.showTrashedTasks');
        Route::delete('/delete/{taskId}', 'Api\TaskController@delete')->name('tasks.delete');
        Route::post('/restore/{taskId}', 'Api\TaskController@restore')->name('tasks.restore');
        Route::put('/mark/{taskId}/done', 'Api\TaskController@markTaskDone')->name('tasks.markDone');
        Route::put('/mark/{taskId}/undone', 'Api\TaskController@markTaskUndone')->name('tasks.markUndone');
    });
});


