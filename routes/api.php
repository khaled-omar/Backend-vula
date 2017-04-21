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

Route::group(['prefix'=>'v1'], function() {
    // Authentication 
    Route::post('register', 'AuthController@Register');
    Route::post('login', 'AuthController@Login');
    

    // Boards 
    Route::post('Boards', 'BoardController@store');
    Route::get('Boards', 'BoardController@index');
    Route::delete('Boards/{board_id}', 'BoardController@destroy');

     // Lists 
    Route::post('Boards/{board_id}/Lists', 'ListController@store');
    Route::get('Boards/{board_id}/Lists', 'ListController@index');
    Route::delete('Lists/{list_id}', 'ListController@destroy');
    

    // Cards 
    Route::post('Boards/{board_id}/Lists/{list_id}/Cards', 'CardController@store');
    Route::delete('Cards/{card_id}', 'CardController@destroy');
    Route::put('Boards/{board_id}/Lists/{list_id}/Cards/{card_id}', 'CardController@update');
    Route::get('Boards/{board_id}/Lists/{list_id}/Cards', 'CardController@index');

});
