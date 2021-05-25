<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('login', 'UserController@login')->name('login');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('me/logout', 'UserController@logout');

    Route::group(['prefix' => 'courses'], function(){
        Route::get('', 'CoursesController@index');
        Route::get('modules', 'ModulesController@index');

        Route::group(['prefix' => 'me'], function(){
            Route::get('', 'CoursesController@meCourses');
            Route::get('deleted', 'CoursesController@fetchDeletedCourses');
            Route::get('{id}', 'CoursesController@show');
            Route::delete('{id}', 'CoursesController@destroy');
            Route::put('{id}', 'CoursesController@update');
            Route::patch('{id}/restore', 'CoursesController@restore');
            Route::post('', 'CoursesController@store');

            Route::group(['prefix' => '{courseId}/modules'], function(){
                Route::get('', 'ModulesController@meModules');
                Route::get('deleted', 'ModulesController@fetchDeletedModules');
                Route::get('{id}', 'ModulesController@show');
                Route::delete('{id}', 'ModulesController@destroy');
                Route::put('{id}', 'ModulesController@update');
                Route::patch('{id}/restore', 'ModulesController@restore');
                Route::post('', 'ModulesController@store');

                Route::group(['prefix' => '{moduleId}/contents'], function(){
                    Route::get('', 'ContentsController@index');
                    Route::get('deleted', 'ContentsController@fetchDeletedContents');
                    Route::get('{id}', 'ContentsController@show');
                    Route::delete('{id}', 'ContentsController@destroy');
                    Route::put('{id}', 'ContentsController@update');
                    Route::patch('{id}/restore', 'ContentsController@restore');
                    Route::post('', 'ContentsController@store');
                });
            });
        });
    });
    
});
