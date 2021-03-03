<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Middleware\AuthCheck;
use App\Func\Board;

/**
 * Index
 */
Route::get('/', 'ApiController@main');
Route::get('/api/{api_code}', 'ApiController@setForm');
Route::post('/send', 'ApiController@send');
//Route::get('/show', 'ApiController@show');