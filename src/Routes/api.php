<?php

use Fhsinchy\Inspire\Controllers;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'api/v1/coinbase','namespace'=>'Jeybin\Coinbase\Controllers'],function(){

    Route::get('inspire', 'CoinbaseController@index');
});