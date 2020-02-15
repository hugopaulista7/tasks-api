<?php

use Illuminate\Http\Request;


// Route::group(['middleware' => ['cors']], function ($router) {
Route::group(['prefix' => 'v1'], function ($router) {
    Route::post('login', '\App\Http\Controllers\Auth\LoginController@auth');
    Route::group(['middleware' => ['auth.basic']], function ($router) {
        Route::get('check', function () {
            return ['success' =>  true];
        });
        Route::get('tasks', 'TasksController@get');
    });
});
// });


