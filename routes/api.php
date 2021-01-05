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
        
    Route::post('auth/login', 'AuthController@login');
    
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
            Route::get('calendar/{id}','EventController@readCalendar');
            Route::post('add','EventController@store');
            Route::put('edit/{id}','EventController@update');
            Route::delete('{id}','EventController@delete');
            Route::post('/destroy','EventController@deleteAll');
        });

        // Auth Routes
        Route::get('auth/user-profile', 'AuthController@userProfile');  

    });

});
