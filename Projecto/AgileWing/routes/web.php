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

//######## -->> RUI <<-- ########
//######## -->> RUI <<-- ########
Route::prefix('users')->group(function(){
    Route::get('', 'UserController@index');
    Route::get('create', 'UserController@create');
    Route::post('', 'UserController@store');
    Route::get('{user}', 'UserController@show');
    Route::get('{user}/edit', 'UserController@edit');
    Route::put('{user}', 'UserController@update');
    Route::delete('{user}', 'UserController@destroy');
   });

Route::prefix('hour_blocks')->group(function(){
    Route::get('', 'HourBlockController@index');
    Route::get('create', 'HourBlockController@create');
    Route::post('', 'HourBlockController@store');
    Route::get('{hourBlock}', 'HourBlockController@show');
    Route::get('{hourBlock}/edit', 'HourBlockController@edit');
    Route::put('{hourBlock}', 'HourBlockController@update');
    Route::delete('{hourBlock}', 'HourBlockController@destroy');
   });

Route::prefix('availability_types')->group(function(){
    Route::get('', 'AvailabilityTypeController@index');
    Route::get('create', 'AvailabilityTypeController@create');
    Route::post('', 'AvailabilityTypeController@store');
    Route::get('{availabilityType}', 'AvailabilityTypeController@show');
    Route::get('{availabilityType}/edit', 'AvailabilityTypeController@edit');
    Route::put('{availabilityType}', 'AvailabilityTypeController@update');
    Route::delete('{availabilityType}', 'AvailabilityTypeController@destroy');
});
Route::prefix('user_types')->group(function(){
    Route::get('', 'UserTypeController@index');
    Route::get('create', 'UserTypeController@create');
    Route::post('', 'UserTypeController@store');
    Route::get('{userType}', 'UserTypeController@show');
    Route::get('{userType}/edit', 'UserTypeController@edit');
    Route::put('{userType}', 'UserTypeController@update');
    Route::delete('{userType}', 'UserTypeController@destroy');
});
//######## -->> RUI <<-- ########
//######## -->> RUI <<-- ########

// ROUTES for Teacher Availabilities
Route::prefix('teacher-availabilities')->group(function(){
    Route::get('', 'TeacherAvailabilityController@index')->name('teacher-availabilities.index');
    Route::get('create', 'TeacherAvailabilityController@create')->name('teacher-availabilities.create');
    Route::post('', 'TeacherAvailabilityController@store')->name('teacher-availabilities.store');
    Route::get('{teacherAvailability}/edit', 'TeacherAvailabilityController@edit')->name('teacher-availabilities.edit');
    Route::put('{teacherAvailability}', 'TeacherAvailabilityController@update')->name('teacher-availabilities.update');
    Route::get('{teacherAvailability}', 'TeacherAvailabilityController@show')->name('teacher-availabilities.show');
    Route::delete('{teacherAvailability}', 'TeacherAvailabilityController@destroy')->name('teacher-availabilities.destroy');
});