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

Route::group(['middleware' => ['api', 'cors']], function () {
        
    Route::post('auth/login', 'AuthController@login')->name('login');;
    
    Route::post('auth/refresh-token', 'AuthController@refresh');

    Route::group(['middleware' => 'auth'], function(){
    
        // Sector Routes
        Route::prefix('sector')->group(function () {
            Route::get('/','SectorController@read');
            Route::post('add','SectorController@store');
        });

        // Event Routes
        Route::prefix('event')->group(function () {
            Route::get('/','EventController@read');
            Route::get('calendar','EventController@readCalendar');
            Route::get('notification','EventController@readNotification');
            Route::get('/detail/{id}','EventController@readDetail');
            Route::post('add','EventController@store');
            Route::put('edit/{id}','EventController@update');
            Route::delete('{id}','EventController@delete');
            Route::post('/destroy','EventController@deleteAll');
        });

        // Auth Routes
        Route::get('auth/user-profile', 'AuthController@userProfile');  

        // User Routes
        Route::prefix('user')->group(function () {
            Route::get('/','UserController@read');
            Route::post('add','UserController@store');
            Route::post('edit/{id}','UserController@update');
            Route::delete('{id}','UserController@delete');
            Route::post('/destroy','UserController@deleteAll');
        });

        // Role Routes
        Route::prefix('role')->group(function () {
            Route::get('/','RoleController@read');
            Route::post('add','RoleController@store');
        });

        // Category Routes
        Route::prefix('category')->group(function () {
            Route::get('/','CategoryController@read');
            Route::post('add','CategoryController@store');
        });

    });

});
