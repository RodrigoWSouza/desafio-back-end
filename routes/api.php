<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('/', 'UserController@store');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::post('/', 'TransactionsController@store');
    });
});


