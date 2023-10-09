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

// ROUTES FOR SCHEDULE ATRIBUTIONS USE CASE

// Route to get the list of classes to then manage the schedule atributions of that classes
Route::prefix('schedule-atribution-course-class')->group(function(){
    Route::get('', 'CourseClassController@indexForScheduleAtribution')->name('course-class.schedule-attribution.index');
    Route::get('create', 'CourseClassController@createForScheduleAtribution')->name('course-class.schedule-attribution.create');
    Route::post('/course-classes', 'CourseClassController@storeForScheduleAtribution')->name('course-class.schedule-attribution.store');
    Route::get('{courseClass}/edit', 'CourseClassController@storeForScheduleAtribution')->name('course-class.schedule-attribution.edit');
    Route::put('{courseClass}', 'CourseClassController@storeForScheduleAtribution')->name('course-class.schedule-attribution.update');
    Route::get('{courseClass}', 'CourseClassController@showForScheduleAtribution')->name('course-class.schedule-attribution.show');
    Route::delete('{courseClass}/destroy', 'CourseClassController@destroyForScheduleAtribution')->name('course-class.schedule-attribution.destroy');
});

// ROUTES for Schedule Atribution
/*Route::prefix('schedule-atribution')->group(function(){
    Route::get('', 'ScheduleAtributionController@index')->name('schedule-atribution.index');
    Route::get('create', 'ScheduleAtributionController@create')->name('schedule-atribution.create');
    Route::post('', 'ScheduleAtributionController@store')->name('schedule-atribution.store');
    Route::get('{scheduleAtribution}/edit', 'ScheduleAtributionController@edit')->name('schedule-atribution.edit');
    Route::put('{scheduleAtribution}', 'ScheduleAtributionController@update')->name('schedule-atribution.update');
    Route::get('{scheduleAtribution}', 'ScheduleAtributionController@show')->name('schedule-atribution.show');
    Route::delete('{scheduleAtribution}', 'ScheduleAtributionController@destroy')->name('schedule-atribution.destroy');
});*/

//ROUTES for Schedule Atribution
 /*Route::prefix('course-classes')->group(function(){
   Route::get('', 'CourseClassController@index')->name('course-classes.index');
    Route::get('create', 'CourseClassController@create')->name('course-classes.create');
    Route::post('', 'CourseClassController@store')->name('course-classes.store');
    Route::get('{courseClass}/edit', 'CourseClassController@edit')->name('course-classes.edit');
    Route::put('{courseClass}', 'CourseClassController@update')->name('course-classes.update');
    Route::get('{courseClass}', 'CourseClassController@show')->name('course-classes.show');
    Route::delete('{courseClass}', 'CourseClassController@destroy')->name('course-classes.destroy');
}); //este código pode ser apagado????*/
