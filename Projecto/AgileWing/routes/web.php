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
//CRUD ROUTES
//Course Class
Route::prefix('course-classes')->group(function(){
    Route::get('', 'CourseClassController@index');
    Route::get('create', 'CourseClassController@create');
    Route::post('', 'CourseClassController@store');
    Route::get('{course-class}', 'CourseClassController@show');
    Route::get('{course-class}/edit', 'CourseClassController@edit');
    Route::put('{course-class}', 'CourseClassController@update');
    Route::delete('{course-class}', 'CourseClassController@destroy');
});


//Hour block course class
Route::prefix('hour-block-course-classes')->group(function(){
    Route::get('', 'HourBlockCourseClassController@index')->name('hour-block-course-classes.index');
    Route::get('create', 'HourBlockCourseClassController@create')->name('hour-block-course-classes.create');
    Route::post('', 'HourBlockCourseClassController@store')->name('hour-block-course-classes.store');
    Route::get('{hourBlockCourseClass}/edit', 'HourBlockCourseClassController@edit')->name('hour-block-course-classes.edit');
    Route::put('{hourBlockCourseClass}', 'HourBlockCourseClassController@update')->name('hour-block-course-classes.update');
    Route::get('{hourBlockCourseClass}', 'HourBlockCourseClassController@show')->name('hour-block-course-classes.show');
    Route::delete('{hourBlockCourseClass}', 'HourBlockCourseClassController@destroy')->name('hour-block-course-classes.destroy');
});