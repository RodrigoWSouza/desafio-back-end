<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/{id}', 'UserController@show');
        Route::post('/', 'UserController@store');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', 'TransactionsController@index');
        Route::get('/{id}', 'TransactionsController@show');
        Route::post('/', 'TransactionsController@store');
    });
});


