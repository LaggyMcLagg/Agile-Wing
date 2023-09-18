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

<<<<<<< Updated upstream
// ROUTES for Courses
Route::prefix('courses')->group(function(){
    Route::get('', 'CourseController@index')->name('courses.index');
    Route::get('create', 'CourseController@create')->name('courses.create');
    Route::post('', 'CourseController@store')->name('courses.store');
    Route::get('{course}/edit', 'CourseController@edit')->name('courses.edit');
    Route::put('{course}', 'CourseController@update')->name('courses.update');
    Route::get('{course}', 'CourseController@show')->name('courses.show');
    Route::delete('{course}', 'CourseController@destroy')->name('courses.destroy');
});
=======
// ROUTES for Schedule Atribution
Route::prefix('schedule-atribution')->group(function(){
    Route::get('', 'ScheduleAtributionController@index')->name('schedule-atribution.index');
    Route::get('create', 'ScheduleAtributionController@create')->name('schedule-atribution.create');
    Route::post('', 'ScheduleAtributionController@store')->name('schedule-atribution.store');
    Route::get('{scheduleAtribution}/edit', 'ScheduleAtributionController@edit')->name('schedule-atribution.edit');
    Route::put('{scheduleAtribution}', 'ScheduleAtributionController@update')->name('schedule-atribution.update');
    Route::get('{scheduleAtribution}', 'ScheduleAtributionController@show')->name('schedule-atribution.show');
    Route::delete('{scheduleAtribution}', 'ScheduleAtributionController@destroy')->name('schedule-atribution.destroy');
});

// ROUTES for Courses Ufcd
Route::prefix('course-ufcd')->group(function(){
    Route::get('', 'CourseUfcdController@index')->name('course-ufcd.index');
    Route::get('create', 'CourseUfcdController@create')->name('course-ufcd.create');
    Route::post('', 'CourseUfcdController@store')->name('course-ufcd.store');
    Route::get('{courseUfcd}/edit', 'CourseUfcdController@edit')->name('course-ufcd.edit');
    Route::put('{courseUfcd}', 'CourseUfcdController@update')->name('course-ufcd.update');
    Route::get('{courseUfcd}', 'CourseUfcdController@show')->name('course-ufcd.show');
    Route::delete('courseUfcd}', 'CourseUfcdController@destroy')->name('course-ufcd.destroy');
});
>>>>>>> Stashed changes
