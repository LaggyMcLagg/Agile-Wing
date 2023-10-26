<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MailVerificationController;


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
   
//register e reset são o registo do user e redefinição de senha. 
//desta forma mantenho só login, logout e confirmação de email por link
Auth::routes(['register' => false, 'reset' => false, 'verify' => true]);

Route::get('/', function () {
    return redirect()->route('login');
});

//rota para verificar email
Route::get('/verify-email/{token}', 'UserController@verifyEmail')->name('verify.email');

//Route to be used with the reset pass button in the show user form
Route::get('reset-password-form/{id}', 'UserController@resetPassword')->name('resetPassword');


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
});    


//ROTAS DISPONIVEIS PARA USER TYPE 1 -> TESTES
Route::middleware(['auth', 'checkUserType1:1'])->group(function(){

    Route::prefix('availability-types')->group(function(){
        Route::get('', 'AvailabilityTypeController@index')->name('availability-types.index');
        Route::post('', 'AvailabilityTypeController@store')->name('availability-types.store');
        Route::put('{id}', 'AvailabilityTypeController@update')->name('availability-types.update');
        Route::delete('{availabilityType}', 'AvailabilityTypeController@destroy')->name('availability-types.destroy');
    });  

    Route::prefix('courses')->group(function(){
        Route::get('', 'CourseController@index')->name('courses.index');
        Route::post('', 'CourseController@store')->name('courses.store');
        Route::put('{id}', 'CourseController@update')->name('courses.update');
        Route::delete('{course}', 'CourseController@destroy')->name('courses.destroy');
    });   
    
    Route::prefix('course-classes')->group(function(){
        Route::get('', 'CourseClassController@index')->name('course-classes.index');
        Route::post('', 'CourseClassController@store')->name('course-classes.store');
        Route::put('{id}', 'CourseClassController@update')->name('course-classes.update');
        Route::delete('{courseClass}', 'CourseClassController@destroy')->name('course-classes.destroy');
    });

    Route::prefix('hour-blocks')->group(function(){
        Route::get('', 'HourBlockController@index')->name('hour-blocks.index');
        Route::post('', 'HourBlockController@store')->name('hour-blocks.store');
        Route::put('{id}', 'HourBlockController@update')->name('hour-blocks.update');
        Route::delete('{hourBlock}', 'HourBlockController@destroy')->name('hour-blocks.destroy');
       }); 

    Route::prefix('hour-block-course-classes')->group(function(){
        Route::get('', 'HourBlockCourseClassController@index')->name('hour-block-course-classes.index');
        Route::post('', 'HourBlockCourseClassController@store')->name('hour-block-course-classes.store');
        Route::put('{id}', 'HourBlockCourseClassController@update')->name('hour-block-course-classes.update');
        Route::delete('{hourBlockCourseClass}', 'HourBlockCourseClassController@destroy')->name('hour-block-course-classes.destroy');
    });

    Route::prefix('pedagogical-groups')->group(function(){
        Route::get('', 'PedagogicalGroupController@index')->name('pedagogical-groups.index');
        Route::post('', 'PedagogicalGroupController@store')->name('pedagogical-groups.store');
        Route::put('{id}', 'PedagogicalGroupController@update')->name('pedagogical-groups.update');
        Route::delete('{pedagogicalGroup}', 'PedagogicalGroupController@destroy')->name('pedagogical-groups.destroy');
    });

    
    Route::prefix('specialization-areas')->group(function(){
        Route::get('', 'SpecializationAreaController@index')->name('specialization-areas.index');
        Route::post('', 'SpecializationAreaController@store')->name('specialization-areas.store');
        Route::put('{id}', 'SpecializationAreaController@update')->name('specialization-areas.update');
        Route::delete('{specializationArea}', 'SpecializationAreaController@destroy')->name('specialization-areas.destroy');
    });

    Route::prefix('ufcds')->group(function(){
        Route::get('', 'UfcdController@index')->name('ufcds.index');
        Route::post('', 'UfcdController@store')->name('ufcds.store');
        Route::put('{id}', 'UfcdController@update')->name('ufcds.update');
        Route::delete('{ufcd}', 'UfcdController@destroy')->name('ufcds.destroy');
    });
    
    Route::prefix('users')->group(function(){
        Route::get('', 'UserController@index')->name('users.index');
        Route::get('create', 'UserController@create')->name('users.create');
        Route::post('', 'UserController@store')->name('users.store');
        Route::get('show/{id}', 'UserController@show');
        Route::get('edit', 'UserController@edit')->name('users.edit');
        Route::put('{id}', 'UserController@update')->name('users.update');
        Route::delete('{user}', 'UserController@destroy')->name('users.destroy');
    });
    
    Route::prefix('user-types')->group(function(){
        Route::get('', 'UserTypeController@index')->name('user-types.index');
        Route::post('', 'UserTypeController@store')->name('user-types.store');
        Route::put('{id}', 'UserTypeController@update')->name('user-types.update');
        Route::delete('{userType}', 'UserTypeController@destroy')->name('user-types.destroy');
    });  

    // ROUTES FOR SCHEDULE ATRIBUTIONS USE CASE
    Route::prefix('schedule-atribution')->group(function(){
        // Route to get the list of classes to then manage the schedule atributions of that classes
        Route::get('', 'CourseClassController@indexCourseClassesPlanning')->name('course-class-schedule-attribution.index');

        //OTHER

        //CRUD
        Route::post('{id}', 'ScheduleAtributionController@index')->name('schedule-atribution.index');
        Route::get('create', 'ScheduleAtributionController@create')->name('schedule-atribution.create');
        Route::post('', 'ScheduleAtributionController@store')->name('schedule-atribution.store');
        Route::get('{id}/edit', 'ScheduleAtributionController@edit')->name('schedule-atribution.edit');
        Route::put('{id}', 'ScheduleAtributionController@update')->name('schedule-atribution.update');
        Route::get('{id}', 'ScheduleAtributionController@show')->name('schedule-atribution.show');
        Route::delete('{id}', 'ScheduleAtributionController@destroy')->name('schedule-atribution.destroy');
    });

    // ROUTES for Teacher Availabilities (Planning Use case)
    Route::prefix('teacher-availabilities-planning')->group(function(){
        //get the users to select one to manage availabilities
        Route::get('', 'UserController@indexTeachers')->name('users.index-teachers');
    });

});

//ROTAS DISPONIVEIS PARA USER TYPE 2 -> TESTES
Route::middleware(['auth', 'checkUserType2:2'])->group(function(){

    // ROUTES for Teacher Availabilities (Teacher use case)
    Route::prefix('user-notes')->group(function(){
        //user notes update
        Route::post('users/update-notes', 'UserController@updateNotes')->name('users.update-notes');
    });

});

//ROTAS COMUNS
Route::middleware(['auth'])->group(function(){

    // ROUTES for Teacher Availabilities (Teacher/Planning Use case)
    Route::prefix('teacher-availabilities')->group(function(){    
        //deal with bulk data
        Route::post('delete-selected', 'TeacherAvailabilityController@deleteSelected')->name('teacher-availabilities.delete-selected');
        Route::post('publish-selected', 'TeacherAvailabilityController@publishSelected')->name('teacher-availabilities.publish-selected');
    
        //crud
        Route::get('create/{id}', 'TeacherAvailabilityController@create')->name('teacher-availabilities.create');
        Route::get('{id}/{userId}/edit', 'TeacherAvailabilityController@edit')->name('teacher-availabilities.edit');
        Route::get('{id}', 'TeacherAvailabilityController@index')->name('teacher-availabilities.index');
        Route::post('', 'TeacherAvailabilityController@store')->name('teacher-availabilities.store');
        Route::put('{id}', 'TeacherAvailabilityController@update')->name('teacher-availabilities.update');
    });

    //ROUTES ALTER PASSWORD
    Route::prefix('users-alterar-pw')->group(function(){
        Route::get('password-form', 'UserController@changePasswordView')->name('users.passwordForm');
        Route::put('password-update', 'UserController@changePasswordLogic')->name('users.passwordUpdate');
    });

});
