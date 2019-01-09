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

Route::middleware('jwt.auth')->get('/shares', 'ApiSharePurchasesController@index');
Route::middleware('jwt.auth')->get('/shares/{shareId}', 'ApiSharePurchasesController@show');
Route::middleware('jwt.auth')->put('/shares/{shareId}', 'ApiSharePurchasesController@update');
Route::middleware('jwt.auth')->post('/shares/{shareId}', 'ApiSharePurchasesController@store');
Route::middleware('jwt.auth')->delete('/shares/{shareId}', 'ApiSharePurchasesController@destroy');
Route::middleware('jwt.auth')->post('/shares/{shareId}/tags', 'ApiSharePurchasesController@saveShareTags');

Route::middleware('jwt.auth')->get('/tags', 'ApiSharePurchasesController@getTags');
