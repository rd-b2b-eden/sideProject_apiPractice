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

Route::group(['namespace' => 'App\Http\Controllers\Api\v1', 'prefix' => 'v1'], function () {
    Route::post('command/data', 'DataController@storeByCommand')->name('api.v1.command.data');
    Route::post('event/data', 'DataController@storeByEvent')->name('api.v1.event.data');
    Route::post('job/data', 'DataController@storeByJob')->name('api.v1.job.data');
});
