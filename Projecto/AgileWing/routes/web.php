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

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
});

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


//CRUD ROUTES
//Course Class
//Since we are using Ids and not objects we must adapt the info in the routes
Route::prefix('course-classes')->group(function(){
    Route::get('', 'CourseClassController@index');
    Route::get('create', 'CourseClassController@create');
    Route::post('', 'CourseClassController@store');
    Route::get('{id}', 'CourseClassController@show');
    Route::get('{id}/edit', 'CourseClassController@edit');
    Route::put('{id}', 'CourseClassController@update');
    Route::delete('{id}', 'CourseClassController@destroy');
});

