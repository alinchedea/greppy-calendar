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

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

//Auth::routes();
Route::get('/login', 'AuthController@login')->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/check', 'AuthController@check');
    //events
    Route::get('event', 'EventController@index');
    Route::post('event', 'EventController@create');
    Route::put('event/{id}', 'EventController@update');
    Route::delete('event/{id}', 'EventController@delete');

});

