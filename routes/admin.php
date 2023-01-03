<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseFAQController;
use App\Http\Controllers\CourseModuleController;
use App\Http\Controllers\CourseResourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\QuizOptionController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\SubModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [AuthController::class,'adminLoginPage'])->name('login.page');
Route::post('/login', [AuthController::class,'adminLogin'])->name('login');

// Route::controller(AuthController::class)->group(function (){
//     Route::get('/admin-login', 'adminLoginPage')->name('login.page');
//     Route::get('/login', 'adminLogin')->name('loginAdmin');
// });

/*-----PERMITTED USER CAN ACCESS THIS PAGE-----*/
Route::group( ['middleware' => 'admin'], function () {

    Route::controller(AuthController::class)->group(function (){
        Route::get('logout', 'adminLogout')->name('logoutAdmin');
    });

    Route::controller(AdminController::class)->group(function (){
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('list', 'admin_list')->name('list');
        Route::get('create', 'create')->name('admins.create');
        Route::post('store', 'store')->name('admins.store');
        Route::get('show/{admin_id}', 'show')->name('show');
        Route::get('profile', 'profile')->name('profile');
        Route::post('update', 'update')->name('update');
        Route::delete('destroy/{admin_id}', 'destroy')->name('destroy');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('user/list', 'user_list')->name('user.list');
        Route::get('user/show/{user_id}', 'show')->name('user.show');
        Route::get('user/edit/{user_id}', 'edit')->name('user.edit');    
        Route::post('user/update/{user_id}', 'update')->name('user.update');    
        Route::delete('user/destroy/{user_id}', 'destroy')->name('user.destroy');    
        Route::get('user/banned/{user_id}', 'banned')->name('user.banned');    
        Route::get('user/un-banned/{user_id}', 'un_banned')->name('user.un-banned');    
        Route::get('user/list/downloadPdf', 'downloadPdf')->name('user.downloadPdf');    
        Route::get('user/list/downloadExcel', 'downloadExcel')->name('user.downloadExcel');    
    });

    Route::controller(CourseController::class)->group(function(){
        Route::get('courses', 'index')->name('course.index');
        Route::get('course/show/{course_id}', 'show')->name('course.show');
        Route::get('course/edit/{course_id}', 'edit')->name('course.edit');
        Route::post('course/store', 'store')->name('course.store');
        Route::get('course/create', 'create')->name('course.create');
        Route::post('course/update/{course_id}', 'update')->name('course.update');
        Route::get('course/publish-status-update/{course_id}', 'update_status')->name('course.update.publish_status');
        Route::delete('course/destroy/{course_id}', 'destroy')->name('course.destroy');
    });

    Route::controller(CourseResourceController::class)->group(function(){
        Route::get('course_resources', 'index')->name('course_resource.index');
        Route::post('course_resource/store', 'store')->name('course_resource.store');
        Route::post('course_resource/update/{course_resource_id}', 'update')->name('course_resource.update');
        Route::delete('course_resource/destroy/{course_resource_id}', 'destroy')->name('course_resource.destroy');

    });

    Route::controller(CourseModuleController::class)->group(function(){
        Route::get('course_modules/course/{course_id}', 'index')->name('course_module.index');
        // Route::get('course_modules/details/{course_id}', 'details')->name('course_module.details');
        Route::get('course_modules/{course_id}', 'create')->name('course_module.create');
        Route::post('course_module/store', 'store')->name('course_module.store');
        Route::post('course_module/update/{course_module_id}', 'update')->name('course_module.update');
        Route::delete('course_module/destroy/{course_module_id}', 'destroy')->name('course_module.destroy');

    });

    Route::controller(SubModuleController::class)->group(function(){
        Route::get('course/sub_modules', 'index')->name('course_sub_module.index');
        Route::get('course/sub_modules/create/{module_id}', 'create')->name('course_sub_module.create');
        Route::post('course/sub_module/store', 'store')->name('course_sub_module.store');
        Route::get('course/sub_module/edit/{sub_module_id}', 'edit')->name('course_sub_module.edit');
        Route::post('course/sub_module/update', 'update')->name('course_sub_module.update');
        Route::delete('course/sub_module/destroy/{sub_module_id}', 'destroy')->name('course_sub_module.destroy');

    });

    Route::controller(CourseFAQController::class)->group(function(){
        Route::get('course_faq', 'index')->name('course_faq.index');
        Route::post('course_faq/store', 'store')->name('course_faq.store');
        Route::post('course_faq/update/{course_faq_id}', 'update')->name('course_faq.update');
        Route::delete('course_faq/destroy/{course_faq_id}', 'destroy')->name('course_faq.destroy');

    });

    Route::controller(QuizQuestionController::class)->group(function(){
        Route::get('course/quiz', 'index')->name('quiz_question.index');
        Route::post('course/quiz/store', 'store')->name('quiz_question.store');
        Route::post('course/quiz/update/{quiz_question_id}', 'update')->name('quiz_question.update');
        Route::get('course/quiz/edit-form/{quiz_question_id}', 'edit_form')->name('quiz_question.edit_form');
        Route::get('course/quiz/destroy/{quiz_question_id}', 'destroy')->name('quiz_question.destroy');
    });

    Route::controller(QuizOptionController::class)->group(function(){
       Route::post('quiz-option/store', 'store')->name('quiz_option.store');
       Route::get('quiz-option/create/{quiz_question_id}', 'getQuizOptionCreateForm')->name('quiz_option.create.form');
       Route::get('quiz-option/edit/{option_id}', 'getQuizOptionEditForm')->name('quiz_option.edit.form');
       Route::post('quiz-option/update', 'update')->name('quiz_option.update');
       Route::get('quiz-option/destroy/{option_id}', 'deleteQuizQuestionOption')->name('quiz_option.destroy');
    });
    Route::controller(EmailSettingController::class)->group(function(){
        Route::get('email/setting', 'index')->name('email_setting.index');
        Route::post('email/setting/store', 'store')->name('email_setting.store');
        Route::post('email/setting/hybernate_store', 'hybernate_store')->name('email_setting.hybernate_store');
        Route::post('email/setting/inactive_email_store', 'inactive_email_store')->name('email_setting.inactive_email_store');
        
     });
});