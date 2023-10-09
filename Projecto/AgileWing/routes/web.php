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

// ROUTES for Courses
Route::prefix('courses')->group(function(){
    Route::get('', 'CourseController@index')->name('courses.index');
    Route::post('', 'CourseController@store')->name('courses.store');
    Route::put('{id}', 'CourseController@update')->name('courses.update');
    Route::delete('{course}', 'CourseController@destroy')->name('courses.destroy');
});

// ROUTES for Hour Blocks
Route::prefix('hour-blocks')->group(function(){
    Route::get('', 'HourBlockController@index')->name('hour-blocks.index');
    Route::post('', 'HourBlockController@store')->name('hour-blocks.store');
    Route::put('{id}', 'HourBlockController@update')->name('hour-blocks.update');
    Route::delete('{hourBlock}', 'HourBlockController@destroy')->name('hour-blocks.destroy');
   });

Route::prefix('users')->group(function(){
    Route::get('', 'UserController@index')->name('users.index');
    Route::get('create', 'UserController@create')->name('users.create');
    Route::post('', 'UserController@store')->name('users.store');
    Route::get('show/{id}', 'UserController@show');
    Route::get('password-form', 'UserController@changePasswordView')->name('users.passwordForm');
    Route::put('password-update', 'UserController@changePasswordLogic')->name('users.passwordUpdate');
    Route::get('edit', 'UserController@edit')->name('users.edit');
    Route::put('{id}', 'UserController@update')->name('users.update');
    Route::delete('{user}', 'UserController@destroy')->name('users.destroy');
   });

Route::prefix('availability-types')->group(function(){
    Route::get('', 'AvailabilityTypeController@index')->name('availability-types.index');
    Route::get('create', 'AvailabilityTypeController@create')->name('availability-types.create');
    Route::post('', 'AvailabilityTypeController@store')->name('availability-types.store');
    Route::get('{availabilityType}', 'AvailabilityTypeController@show')->name('availability-types.show');
    Route::get('{availabilityType}/edit', 'AvailabilityTypeController@edit')->name('availability-types.destroy');
    Route::put('{availabilityType}', 'AvailabilityTypeController@update')->name('availability-types.update');
    Route::delete('{availabilityType}', 'AvailabilityTypeController@destroy')->name('availability-types.destroy');
});

Route::prefix('user-types')->group(function(){
    Route::get('', 'UserTypeController@index')->name('user-types.index');
    Route::get('create', 'UserTypeController@create')->name('user-types.create');
    Route::post('', 'UserTypeController@store')->name('user-types.store');
    Route::get('{userType}', 'UserTypeController@show')->name('user-types.show');
    Route::get('{userType}/edit', 'UserTypeController@edit')->name('user-types.edit');
    Route::put('{userType}', 'UserTypeController@update')->name('user-types.update');
    Route::delete('{userType}', 'UserTypeController@destroy')->name('user-types.destroy');
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

// ROUTES FOR SCHEDULE ATRIBUTIONS USE CASE

// Route to get the list of classes to then manage the schedule atributions of that classes
Route::prefix('schedule-atribution-course-class')->group(function(){
    Route::get('', 'CourseClassController@indexForScheduleAtribution')->name('course-class-schedule-attribution.index');
});

// ROUTES for Schedule Atribution
Route::prefix('schedule-atribution')->group(function(){
    Route::post('{courseClass}', 'ScheduleAtributionController@index')->name('schedule-atribution.index');
    Route::get('create', 'ScheduleAtributionController@create')->name('schedule-atribution.create');
    Route::post('', 'ScheduleAtributionController@store')->name('schedule-atribution.store');
    Route::get('{scheduleAtribution}/edit', 'ScheduleAtributionController@edit')->name('schedule-atribution.edit');
    Route::put('{scheduleAtribution}', 'ScheduleAtributionController@update')->name('schedule-atribution.update');
    Route::get('{scheduleAtribution}', 'ScheduleAtributionController@show')->name('schedule-atribution.show');
    Route::delete('{scheduleAtribution}', 'ScheduleAtributionController@destroy')->name('schedule-atribution.destroy');
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

Route::prefix('ufcds')->group(function(){
    Route::get('', 'UfcdController@index')->name('ufcds.index');
    Route::get('create', 'UfcdController@create')->name('ufcds.create');
    Route::post('', 'UfcdController@store')->name('ufcds.store');
    Route::get('{ufcd}/edit', 'UfcdController@edit')->name('ufcds.edit');
    Route::put('{ufcd}', 'UfcdController@update')->name('ufcds.update');
    Route::get('{ufcd}', 'UfcdController@show')->name('ufcds.show');
    Route::delete('{ufcd}', 'UfcdController@destroy')->name('ufcds.destroy');
});

