<?php

use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify' => true
]);

Route::get('/home', 'HomeController@index')->name('home') -> Middleware('verified');

//####### -> ROTAS RUI <- #######
Route::prefix('user-types')->group(function(){
    Route::get('', 'UserTypeController@index');
    Route::get('create', 'UserTypeController@create');
    Route::post('', 'UserTypeController@store');
    Route::get('{userType}', 'UserTypeController@show');
    Route::get('{userType}/edit', 'UserTypeController@edit');
    Route::put('{userType}', 'UserTypeController@update');
    Route::delete('{userType}', 'UserTypeController@destroy');
    });


//####### -> ROTAS RUI <- #######