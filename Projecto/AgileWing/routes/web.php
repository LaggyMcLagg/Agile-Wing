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

// Auth::routes([
//     'verify' => true
// ]);

//register e reset são o registo do user e redefinição de senha. 
//desta forma mantenho só login, logout e confirmação de email por link
Auth::routes(['register' => false, 'reset' => false, 'verify' => true]);


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
});    

//CRUD ROUTES

//Hour block course class
Route::prefix('hour-block-course-classes')->group(function(){
    Route::get('', 'HourBlockCourseClassController@index')->name('hour-block-course-classes.index');
    Route::post('', 'HourBlockCourseClassController@store')->name('hour-block-course-classes.store');
    Route::put('{id}', 'HourBlockCourseClassController@update')->name('hour-block-course-classes.update');
    Route::delete('{hourBlockCourseClass}', 'HourBlockCourseClassController@destroy')->name('hour-block-course-classes.destroy');
});

// ROUTES for Pedagogical Groups
Route::prefix('pedagogical-groups')->group(function(){
    Route::get('', 'PedagogicalGroupController@index')->name('pedagogical-groups.index');
    Route::post('', 'PedagogicalGroupController@store')->name('pedagogical-groups.store');
    Route::put('{id}', 'PedagogicalGroupController@update')->name('pedagogical-groups.update');
    Route::delete('{pedagogicalGroup}', 'PedagogicalGroupController@destroy')->name('pedagogical-groups.destroy');
});

// ROUTES for Course Class
Route::prefix('course-classes')->group(function(){
    Route::get('', 'CourseClassController@index')->name('course-classes.index');
    Route::post('', 'CourseClassController@store')->name('course-classes.store');
    Route::put('{id}', 'CourseClassController@update')->name('course-classes.update');
    Route::delete('{courseClass}', 'CourseClassController@destroy')->name('course-classes.destroy');
});

// ROUTES for specialization-areas
Route::prefix('specialization-areas')->group(function(){
    Route::get('', 'SpecializationAreaController@index')->name('specialization-areas.index');
    Route::post('', 'SpecializationAreaController@store')->name('specialization-areas.store');
    Route::put('{id}', 'SpecializationAreaController@update')->name('specialization-areas.update');
    Route::delete('{specializationArea}', 'SpecializationAreaController@destroy')->name('specialization-areas.destroy');
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

// ROUTES for availability-types   
Route::prefix('availability-types')->group(function(){
    Route::get('', 'AvailabilityTypeController@index')->name('availability-types.index');
    Route::post('', 'AvailabilityTypeController@store')->name('availability-types.store');
    Route::put('{id}', 'AvailabilityTypeController@update')->name('availability-types.update');
    Route::delete('{availabilityType}', 'AvailabilityTypeController@destroy')->name('availability-types.destroy');
});    

// ROUTES for user-types
Route::prefix('user-types')->group(function(){
    Route::get('', 'UserTypeController@index')->name('user-types.index');
    Route::post('', 'UserTypeController@store')->name('user-types.store');
    Route::put('{id}', 'UserTypeController@update')->name('user-types.update');
    Route::delete('{userType}', 'UserTypeController@destroy')->name('user-types.destroy');
});    

// ROUTES for ufcds
Route::prefix('ufcds')->group(function(){
    Route::get('', 'UfcdController@index')->name('ufcds.index');
    Route::post('', 'UfcdController@store')->name('ufcds.store');
    Route::put('{id}', 'UfcdController@update')->name('ufcds.update');
    Route::delete('{ufcd}', 'UfcdController@destroy')->name('ufcds.destroy');
});

//ROUTES for users
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
