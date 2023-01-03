<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\CourseApiController;
use App\Http\Controllers\Api\V1\GuestApiHelperController;
use App\Http\Controllers\Api\V1\CourseFaqApiController;
use App\Http\Controllers\Api\V1\SubModuleApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix( '/v1' )->group( function () {  //prefix domain/api/v1/

    Route::any('registration', [LoginController::class,'guestRregistration']);
    Route::post('login', [LoginController::class,'login']);

Route::middleware('auth:sanctum')->group( function(){

    Route::any('logout', [LoginController::class,'logout']);

    //Course Related API & others
    Route::controller(CourseApiController::class)->group(function (){
        Route::get('course/details/{course_id}', 'courseDetails')->name('course.deatils');
        Route::get('course/public_details/{course_id}', 'courseDetailsWithoutEnroll')->name('course.public_deatils');
        Route::get('courses/my', 'myCourses')->name('myCourse');
        Route::get('courses/all', 'allCourses')->name('allCourse');
        Route::post('course-enrollment', 'enrollment')->name('course.enrollment');

        //Course with Module
        Route::get('course/course_with_module_details/{course_id}', 'courseDetailsWithModuleDetails');
        Route::get('getQuiz/course/{course_id}/module/{module_id}', 'getQuiz');

        //Quiz Submission
        Route::post('course/{course_id}/module/{module_id}/quiz/submission','quizSubmission');
        //Get QuizResult
        Route::get('course/{course_id}/module/{module_id}/quiz/result','quizResult');

        //UnlockNextModule
        Route::get('course/{course_id}/module/{module_id}/unlockSubmodule','unlockSubModule');
    });

    Route::controller(SubModuleApiController::class)->group(function (){

        //Submodule Submission - submit after finish every submodule
        Route::post('course/{course_id}/module/{module_id}/submit-submodule', 'submodule_submission');

    });

    Route::controller(UserApiController::class)->group(function (){
        Route::get('user/profile', 'profile')->name('user.profile');
        Route::post('user/profile/update', 'profile_update')->name('user.profile.update');
        Route::post('user/update-profile-photo', 'profile_photo_update')->name('user.profile-photo.update');
        Route::post('user/change_password', 'change_password')->name('user.change_password');
    });

    Route::controller(CourseFaqApiController::class)->group(function (){
        Route::get('course/faq', 'courseFAQ')->name('course.deatils');
    });

    Route::controller(TestController::class)->group(function (){
        Route::get('test/course/course_with_module_details/{course_id}', 'courseDetailsWithModuleDetails');
    });

});

//Some Guest API

Route::controller(GuestApiHelperController::class)->group(function (){
    Route::get('required-for-registration', 'required_for_registration')->name('helper.user.registration');

     //*==== Depency dropdown api list ===*//
     Route::get( 'geo_list_by_division/{division_id}', 'geo_list_by_division' );
     Route::get( 'geo_list_by_district/{district_id}', 'geo_list_by_district' );
    //  Route::get( 'geo_list_by_upazila/{upazila_id}', 'geo_list_by_upazila' );
});

});
