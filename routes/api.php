<?php

use Illuminate\Http\Request;

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


//to-do-list
Route::group(['prefix' => 'todo'], function () {
    Route::get('/', 'TodoController@index');
    Route::post('/', 'TodoController@store');
    Route::post('/update-done-status/{id}', 'TodoController@updateDone');
    Route::post('/delete/{id}', 'TodoController@delete');
});


//crud-name Tugas AJAX
Route::group(['prefix' => 'crud-name'], function(){
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::post('/update/{id}', 'UserController@update');
    Route::post('/delete/{id}', 'UserController@delete');
    Route::get('/{id}', 'UserController@edit');
});

