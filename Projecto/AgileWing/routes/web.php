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

// Test Routes
Route::get('/page1', function () {
    return view('layouts.test');
});


Route::get('/page2', function () {
    return view('layouts.test');
});

Route::get('/page3', function () {
    return view('layouts.test-modal');
});

// End Test Routes

Auth::routes();

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('/home', 'HomeController@index')->name('home');

//ROTAS CONTENT TABLE FORMADORES
//rever quais os métodos CRUD não vão ser utilizados
Route::prefix('users')->group(function(){
    Route::get('', 'UserController@index');
    Route::get('create', 'UserController@create');
    Route::post('', 'UserController@store');
    Route::get('{user}', 'UserController@show');
    Route::get('{user}/edit', 'UserController@edit');
    Route::put('{user}', 'UserController@update');
    Route::delete('{user}', 'UserController@destroy');
   });
