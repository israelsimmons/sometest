<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/shares', 'SharePurchasesController@index')->name('shares');

Route::prefix('shares')->group(function() {
    Route::get('/', 'SharePurchasesController@index')->name('shares.index');
    Route::get('/form', 'SharePurchasesController@create')->name('shares.create');
    Route::post('/form', 'SharePurchasesController@store')->name('shares.store');
    Route::delete('/form', 'SharePurchasesController@destroy')->name('shares.destroy');
    Route::get('/{id}', 'SharePurchasesController@show')->name('shares.show');
});

Route::middleware('auth:web')->get('/vuejs/{any}', function(){
    return view('vuejs');
})->where('any', '.*');
