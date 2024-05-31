<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('events', 'App\Http\Controllers\EventController@index');
Route::get('events/flights/next-week', 'App\Http\Controllers\EventController@flightsNextWeek');
Route::get('events/standby/next-week', 'App\Http\Controllers\EventController@standbyNextWeek');
Route::get('events/flights/{location}', 'App\Http\Controllers\EventController@flightsByLocation');
Route::post('events/upload', 'App\Http\Controllers\EventController@upload');

