<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['cors']], function ($router) {
    Route::group(['prefix' => 'v1'], function ($router) {
        Route::post('login', '\App\Http\Controllers\Auth\LoginController@auth')->name('auth');
        Route::group(['middleware' => 'auth:api'], function ($router) {
            Route::get('check', function () {
                return ['success' =>  true];
            });


            Route::get('tasks', 'TasksController@get');
            Route::get('tasks/archived', 'TasksController@getArchived');
            Route::get('tasks/{id}', 'TasksController@getSingle');
            Route::get('tasks/delete/{id}', 'TasksController@delete');
            Route::get('tasks/get/past', 'TasksController@getPast');
            Route::post('tasks/create', 'TasksController@create');
            Route::post('tasks/edit', 'TasksController@edit');
            Route::post('tasks/change-status', 'TasksController@changeStatus');


            Route::get('categories', 'CategoriesController@get');
            Route::get('categories/{id}', 'CategoriesController@getSingle');
            Route::post('/categories/create', 'CategoriesController@create');
            Route::get('/categories/delete/{id}', 'CategoriesController@delete');
        });
    });
});


