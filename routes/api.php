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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function () {

    // Sector Routes
    Route::prefix('sector')->group(function () {
        Route::get('/','SectorController@read');
        Route::post('add','SectorController@store');
    });

    // Event Routes
    Route::prefix('event')->group(function () {
        Route::get('/','EventController@read');
        Route::get('calendar','EventController@readCalendar');
        Route::post('add','EventController@store');
        Route::put('edit/{id}','EventController@update');
        Route::delete('{id}','EventController@delete');
        Route::post('/destroy','EventController@deleteAll');
    });

});
