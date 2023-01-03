<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoFrameController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Models\CourseEnrollment;
// use File;
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

Route::get('/test', function () {
    // public function test(){
    return generateUniqueKey();
    // }
    // return \File::get(public_path() . '/modules/module5-draft-1/index.html');
});

//   Route::get('/test-ano', function() {
//     return \File::get(public_path() . '/modules/module7-draft-1/index.html');
//   });

Route::get('/test-certificate', function () {
    return view('users.certificate.certificate_pdf');
});

//AREA Retrive Routes

Route::get('/get-districts/{division_id}', [\App\Http\Controllers\GeoController::class, 'getFilteredDistrict']);
Route::get('/get-upazila/{district_id}', [\App\Http\Controllers\GeoController::class, 'getFilteredUpazila']);
Route::get('/get-union/{upazila_id}', [\App\Http\Controllers\GeoController::class, 'getFilteredUnion']);


Route::get('change-locale/{locale}', [AuthController::class, 'changeLocale'])->name('change.locale');

Route::controller(CourseController::class)->group(function () {
    Route::get('courses', 'course_list')->name('user.course.cources');
    Route::get('course_details/{course_id}', 'courseDetailsPublic')->name('public.course.details');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('user.index');
    Route::get('/user/login', 'login')->name('login');
    Route::post('login', 'loginInUser')->name('user.login');
    Route::post('register', 'registerUser')->name('user.create');
    Route::get('user/register', 'userRegistrationPage')->name('user.register.page');
});

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('logout', 'logoutUser')->name('user.logout');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('user/profile', 'profile')->name('user.profile');
        Route::get('user/profile/edit/{user_id}', 'edit')->name('user.edit');
        Route::post('user/update', 'update')->name('user.update');
        Route::post('user/image/update', 'updateImage')->name('user.image.update');
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('user.dashboard');
    });

    Route::controller(VideoFrameController::class)->group(function () {
        Route::get('course', 'index')->name('user.course.index');
        Route::get('course/module/{module_id}/{sub_module_id}/{type}/{btn_type?}', 'modulePlayer')->name('module.video_payer');
        Route::get('unlock_next_content', 'unlock_next_content')->name('unlock_next_content');
    });

    Route::controller(QuizQuestionController::class)->group(function () {
        Route::get('course/{course_id}/module/{module_id}/quiz', 'quiz')->name('user.quizes.quizPage');
        Route::post('quiz/submission', 'quizSubmission')->name('user.quizes.submission');
    });

    Route::controller(CourseController::class)->group(function () {
        // Route::get('courses', 'course_list')->name('user.course.cources');
        Route::get('my_courses', 'my_courses')->name('user.course.my_cources');
        Route::get('course/details/{course_id}', 'courseDetails')->name('user.course.details');


        Route::get('welcome/{module_id}', 'welcome')->name('welcome.message');
    });
    Route::controller(CourseEnrollmentController::class)->group(function () {
        Route::get('course/enroll', 'enrollment')->name('user.course.enrollment');
    });

    Route::controller(CertificateController::class)->group(function () {
        Route::get('certificate/download/{course_id}', 'download')->name('user.certificate.download');
    });
});
