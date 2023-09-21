<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
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
    Route::get('', 'CourseClassController@index')->name('course-classes.index');
    Route::get('create', 'CourseClassController@create')->name('course-classes.create');
    Route::post('', 'CourseClassController@store')->name('course-classes.store');
    Route::get('{courseClass}/edit', 'CourseClassController@edit')->name('course-classes.edit');
    Route::put('{courseClass}', 'CourseClassController@update')->name('course-classes.update');
    Route::get('{courseClass}', 'CourseClassController@show')->name('course-classes.show');
    Route::delete('{courseClass}', 'CourseClassController@destroy')->name('course-classes.destroy');
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

// ROUTES for Pedagogical Groups
Route::prefix('pedagogical-groups')->group(function(){
    Route::get('', 'PedagogicalGroupController@index')->name('pedagogical-groups.index');
    Route::get('create', 'PedagogicalGroupController@create')->name('pedagogical-groups.create');
    Route::post('', 'PedagogicalGroupController@store')->name('pedagogical-groups.store');
    Route::get('{pedagogicalGroup}/edit', 'PedagogicalGroupController@edit')->name('pedagogical-groups.edit');
    Route::put('{pedagogicalGroup}', 'PedagogicalGroupController@update')->name('pedagogical-groups.update');
    Route::get('{pedagogicalGroup}', 'PedagogicalGroupController@show')->name('pedagogical-groups.show');
    Route::delete('{pedagogicalGroup}', 'PedagogicalGroupController@destroy')->name('pedagogical-groups.destroy');
});

// ROUTES for Pedagogical Group Users
Route::prefix('pedagogical-group-users')->group(function(){
    Route::get('', 'PedagogicalGroupUserController@index')->name('pedagogical-group-users.index');
    Route::get('create', 'PedagogicalGroupUserController@create')->name('pedagogical-group-users.create');
    Route::post('', 'PedagogicalGroupUserController@store')->name('pedagogical-group-users.store');
    Route::get('{pedagogicalGroupUser}/edit', 'PedagogicalGroupUserController@edit')->name('pedagogical-group-users.edit');
    Route::put('{pedagogicalGroupUser}', 'PedagogicalGroupUserController@update')->name('pedagogical-group-users.update');
    Route::get('{pedagogicalGroupUser}', 'PedagogicalGroupUserController@show')->name('pedagogical-group-users.show');
    Route::delete('{pedagogicalGroupUser}', 'PedagogicalGroupUserController@destroy')->name('pedagogical-group-users.destroy');
});

Route::prefix('ufcds')->group(function(){
    Route::get('', 'UfcdController@index')->name('ufcds.index');
    Route::get('create', 'UfcdController@create')->name('ufcds.create');
    Route::post('', 'UfcdController@store')->name('ufcds.store');
    Route::get('{ufcd}/edit', 'UfcdController@edit')->name('ufcds.edit');
    Route::put('{ufcd}', 'UfcdController@update')->name('ufcds.update');
    Route::get('{ufcd}', 'UfcdController@show')->name('ufcds.show');
    Route::delete('{ufcd}', 'UfcdController@destroy')->name('ufcds.destroy');
});


Route::prefix('specialization-area-users')->group(function(){
    Route::get('', 'SpecializationAreaUserController@index')->name('specialization-area-users.index');
    Route::get('create', 'SpecializationAreaUserController@create')->name('specialization-area-users.create');
    Route::post('', 'SpecializationAreaUserController@store')->name('specialization-area-users.store');
    Route::get('{specializationAreaUser}/edit', 'SpecializationAreaUserController@edit')->name('specialization-area-users.edit');
    Route::put('{specializationAreaUser}', 'SpecializationAreaUserController@update')->name('specialization-area-users.update');
    Route::get('{specializationAreaUser}', 'SpecializationAreaUserController@show')->name('specialization-area-users.show');
    Route::delete('{specializationAreaUser}', 'SpecializationAreaUserController@destroy')->name('specialization-area-users.destroy');
});

