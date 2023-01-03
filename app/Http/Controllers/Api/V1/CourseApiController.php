<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Components\Traits\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\courseDetailsResource;
use App\Http\Resources\CourseWithModuleAndQuizResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseModule;
use App\Models\CourseResult;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\ResultDetails;
use App\Models\SubModule;
use App\Models\UnlockModule;
use App\Models\UnlockQuiz;
use App\Models\UnlockSubModule;
use App\Models\UserFinishedModule;
use App\Models\UserFinishedSubModules;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class CourseApiController extends Controller
{
    use Message;

    public function courseDetails($course_id)
    {

        $auth_id = Auth::id();
        if ($auth_id == null || !$auth_id) {
            return $this->apiOutput(401, 'User UnAuthorized');
        }


        $has_enrolled_or_not = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();

        if (empty($has_enrolled_or_not)) {
            return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
        }

        $courseDetails = Course::with('course_modules')->find($course_id);
        if (empty($courseDetails)) {
            return $this->apiOutput(400, 'Copurse can not found!');
        }

        $total_enroll = CourseEnrollment::where('course_id', $course_id)->count();

        $course_detail['id']            = $courseDetails->id ?? null;
        $course_detail['course_title']  = $courseDetails->course_title ?? null;
        $course_detail['about_course']  = $courseDetails->course_description ?? null;
        $course_detail['learning_outcome'] = $courseDetails->course_outcome ?? null;
        $course_detail['cover_photo']   = $courseDetails->getImagePath($course_id) ?? null;
        $course_detail['total_enroll']  = $total_enroll ?? 0;
        $course_detail['duration']      = $courseDetails->course_duration ?? null;
        $course_detail['lesson']        = $courseDetails->course_modules != null ? $courseDetails->course_modules->count() : null;
        $course_detail['complete_rate'] = 0;
        // $module_status = UserFinishedModule::where('user_id',$auth_id)->where('course_id',$course_id)->get();



        $this->apiSuccess();
        $this->data['course_details'] = $course_detail;
        // $this->data['finished_modules'] = $module_status;

        return $this->apiOutput(200, 'Course Details');
    }

    public function courseDetailsWithoutEnroll($course_id)
    {
        $auth_id = Auth::id();
        if ($auth_id == null || !$auth_id) {
            return $this->apiOutput(401, 'User UnAuthorized');
        }


        // $has_enrolled_or_not= CourseEnrollment::where('user_id',$auth_id)->where('course_id',$course_id)->first();

        // if(empty($has_enrolled_or_not)){
        //     return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
        // }

        $courseDetails = Course::with('course_modules')->find($course_id);
        if (empty($courseDetails)) {
            return $this->apiOutput(400, 'Copurse can not found!');
        }

        $total_enroll = CourseEnrollment::where('course_id', $course_id)->count();

        $course_detail['id']            = $courseDetails->id ?? null;
        $course_detail['course_title']  = $courseDetails->course_title ?? null;
        $course_detail['about_course']  = $courseDetails->course_description ?? null;
        $course_detail['learning_outcome'] = $courseDetails->course_outcome ?? null;
        $course_detail['cover_photo']   = $courseDetails->getImagePath($course_id) ?? null;
        $course_detail['total_enroll']  = $total_enroll ?? 0;
        $course_detail['duration']      = $courseDetails->course_duration ?? null;
        $course_detail['lesson']        = $courseDetails->course_modules != null ? $courseDetails->course_modules->count() : null;
        // $module_status = UserFinishedModule::where('user_id',$auth_id)->where('course_id',$course_id)->get();



        $this->apiSuccess();
        $this->data['course_details'] = $course_detail;
        // $this->data['finished_modules'] = $module_status;

        return $this->apiOutput(200, 'Course Details');
    }

    public function myCourses()
    {
        $auth_id = Auth::id();

        if ($auth_id == null || !$auth_id) {
            return $this->apiOutput(401, 'User UnAuthorized');
        }

        $auth_course_ids = CourseEnrollment::where('user_id', $auth_id)->pluck('course_id');

        $courses = Course::whereIn('id', $auth_course_ids)->active()->get();

        if (empty($courses)) {
            $this->apiSuccess();
            $this->data = [];
            return $this->apiOutput(200, 'No Course Available for you!');;
        }

        $courses->map(function ($course, $key) {
            $course->cover_photo = $course->getImagePath($course->id);
            $course->complete_rate = $course->getCompleteRate();
            // $course->course_category = $course->getCourseCategory() ?? null;
            return $course;
        });


        $this->apiSuccess();
        $this->data = $courses;

        return $this->apiOutput(200, 'My Course List!');
    }

    public function allCourses()
    {
        $auth_id = Auth::id();

        if ($auth_id == null || !$auth_id) {
            return $this->apiOutput(401, 'User UnAuthorized');
        }

        $courses = Course::orderBy('id', 'desc')->active()->get();

        if (empty($courses)) {
            $this->apiSuccess();
            $this->data = [];
            return $this->apiOutput(200, 'No Course Available');
        }

        $courses->map(function ($course, $key) {
            $course->cover_photo = $course->getImagePath($course->id);
            // $course->course_category = $course->getCourseCategory() ?? null;
            return $course;
        });


        $this->apiSuccess();
        $this->data = $courses;

        return $this->apiOutput(200, 'Course List!');
    }

    public function enrollment(Request $request)
    {
        DB::beginTransaction();
        try {
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $course = Course::find($request->course_id);
            if (empty($course)) {
                return $this->apiOutput(400, 'Course not found');
            }

            $has_already_enroll_this_course = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $request->course_id)->first();

            if (!empty($has_already_enroll_this_course) && !empty($auth_id)) {
                return $this->apiOutput(400, 'Already Enrolled');
            }

            $enroll = CourseEnrollment::create([
                'user_id'       => $auth_id,
                'course_id'     => $request->course_id,
                'last_visit'    => Carbon::now(),
            ]);

            $first_module_and_sub_module = $this->get_first_module_and_sub_module($request->course_id);

            //unlock 1st module and submodule when enroll
            UnlockModule::create([
                'user_id'  => $auth_id,
                'course_id'     => $request->course_id,
                'module_id' => $first_module_and_sub_module['first_module_id'],
                'submit_status' => 1,
            ]);

            UnlockSubModule::create([
                'user_id'  => $auth_id,
                'sub_module_id' => $first_module_and_sub_module['first_sub_module_id'],
                'submit_status' => 1,
            ]);

            DB::commit();

            $this->apiSuccess();
            $this->data = [];

            return $this->apiOutput(200, 'Course enrollment successful!');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }


    public function courseDetailsWithModuleDetails(Request $request, $course_id)
    {
        try {
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $has_enrolled_or_not = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();

            if (empty($has_enrolled_or_not)) {
                return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
            }

            $course_details = Course::with(['course_modules', 'course_modules.sub_modules'])->where('id', $course_id)->first();
            $course         = (new CourseWithModuleAndQuizResource($course_details));

            $this->apiSuccess();
            $this->data = $course;
            return $this->apiOutput(200, 'Course with module details!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }

    public function getQuiz(Request $request, $course_id, $module_id)
    {

        try {
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $has_enrolled_or_not = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();

            if (empty($has_enrolled_or_not)) {
                return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
            }

            $quizes    = QuizQuestion::with('options')->where('course_id', $course_id)->where('module_id', $module_id)->get();
            $this->apiSuccess();
            $this->data = $quizes;
            return $this->apiOutput(200, 'Quiz list!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }


    public function get_first_module_and_sub_module($course_id)
    {

        $data = [];

        $first_module  = CourseModule::where('course_id', $course_id)->orderBy('id', 'asc')->first();
        $first_sub_module  = SubModule::where('module_id', $first_module->id)->orderBy('id', 'asc')->first();

        $data['first_module_id'] = $first_module->id ?? null;
        $data['first_sub_module_id'] = $first_sub_module->id ?? null;

        return $data;
    }

    public function quizSubmission(Request $request, $course_id, $module_id)
    {
        DB::beginTransaction();
        try {
            $total_question = $request->total_question;
            $total_right_ans = $request->total_right_ans;
            if ($total_question < $total_right_ans) {
                return $this->apiOutput(400, 'Total right ans is less than total right ans');
            }

            if ($total_question <= 0) {
                return $this->apiOutput(400, 'Please give validate input');
            }
            $rating          =  $request->percent;
            // $rating          = (($total_right_ans*100)/$total_question);

            if ($rating < 80) {
                return $this->apiOutput(400, 'You are not eligible for next module!');
            }


            $module = CourseModule::find($module_id);
            $auth_id = Auth::id();

            if (empty($auth_id)) {
                return $this->apiOutput(401, 'You are unauthorized!');
            }

            $has_enroll = CourseEnrollment::where('course_id', $course_id)->where('user_id', $auth_id)->first();
            if (empty($has_enroll)) {
                return $this->apiOutput(400, 'You have not any enrollment for this course!');
            }

            $already_submit_same_module = ResultDetails::where('user_id', $auth_id)->where('course_id', $course_id)->where('module_id', $module_id)->first();
            if (!empty($already_submit_same_module)) {
                return $this->apiOutput(400, 'Already given an exam!');
            }

            $unlock_module_id = $request->unlock_module_id;
            if ($unlock_module_id != null) {
                $check_request_module_is_valid = CourseModule::find($unlock_module_id);
                if (empty($check_request_module_is_valid) || $check_request_module_is_valid->course_id != $course_id) {
                    return $this->apiOutput(400, 'Next module can not be found!');
                }

                $unlock_sub_module = SubModule::where('module_id', $unlock_module_id)->orderBy('id', 'asc')->first();
            }


            $result_details = ResultDetails::create([
                'user_id' => $auth_id,
                'course_id' => $course_id,
                'module_id' => $module_id,
                'total_question' => $total_question,
                'total_correct' => $total_right_ans,
                'result' => $rating,
            ]);

            $exist_result = CourseResult::where('course_id', $course_id)->where('user_id', $auth_id)->first();
            $avg  = ResultDetails::where('course_id', $course_id)->where('user_id', $auth_id)->avg('result');
            $total_module = CourseModule::where('course_id', $course_id)->count();

            if (!empty($exist_result)) {
                $exist_result->number_of_finish_module = ++$exist_result->number_of_finish_module;
                $exist_result->final_result = $avg;
                $exist_result->save();
            } else {
                CourseResult::create([
                    'user_id' => $auth_id,
                    'course_id' => $course_id,
                    'total_module' => $total_module,
                    'number_of_finish_module' => 1,
                    'final_result' => $avg,
                ]);
            }
            if ($unlock_module_id != null) {
                UnlockModule::create([
                    'user_id' => $auth_id,
                    'module_id' => $unlock_module_id,
                    'submit_status' => 1,
                ]);


                if (!empty($unlock_sub_module)) {
                    UnlockSubModule::create([
                        'user_id' => $auth_id,
                        'sub_module_id' => $unlock_sub_module->id,
                        'submit_status' => 1,
                    ]);
                }
            }

            UserFinishedModule::create([
                'user_id' => $auth_id,
                'module_id' => $request->current_module_id,
                'submit_status' => 1,
            ]);

            DB::commit();

            $data['user_id'] = $auth_id;
            $data['course_id'] = $course_id;
            $data['module_id'] = $module_id;
            $data['result'] = $rating;
            $data['average_result'] = $avg;

            $this->apiSuccess();
            $this->data = $data;
            return $this->apiOutput(200, 'Quiz has been submitted and unlock next module!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->apiOutput($exception->getCode(), $this->getError($exception));
        }
    }


    public function unlockSubModule(Request $request, $course_id, $module_id)
    {
        try {

            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $has_enrolled_or_not = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();

            if (empty($has_enrolled_or_not)) {
                return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
            }

            $check_request_module_is_valid = CourseModule::find($module_id);
            if (empty($check_request_module_is_valid) || $check_request_module_is_valid->course_id != $course_id) {
                return $this->apiOutput(400, 'Module is not valid!');
            }
            if ($request->query('quiz') && $request->query('quiz') == true) {

                $has_already_unlock = UnlockQuiz::where('user_id', $auth_id)->where('course_id', $course_id)->where('module_id', $module_id)->first();
                if (!empty($has_already_unlock)) {
                    return $this->apiOutput(400, 'Already unlock this quiz!');
                }
                $unlockQ = UnlockQuiz::create([
                    'user_id' => $auth_id,
                    'course_id' => $course_id,
                    'module_id' => $module_id,
                    'quiz_unlock_status' => 1,
                ]);

                UserFinishedSubModules::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $request->sub_module_id,
                    'submit_status' => 1,
                ]);
                $this->apiSuccess();
                $this->data = $unlockQ;
                return $this->apiOutput(200, 'Unlock Quiz');
            } else {
                $unlock_sub_module_id = $request->unlock_sub_module_id ?? null;
                if ($unlock_sub_module_id == null) {
                    return $this->apiOutput(400, 'Requested submodule id is null!');
                }
                $check_request_sub_module_is_valid = SubModule::find($unlock_sub_module_id);
                if (empty($check_request_sub_module_is_valid) || $check_request_sub_module_is_valid->module_id != $module_id) {
                    return $this->apiOutput(400, 'Url parameter not valid!');
                }

                $has_already_unlock = UnlockSubModule::where('user_id', $auth_id)->where('sub_module_id', $unlock_sub_module_id)->first();

                if (!empty($has_already_unlock)) {
                    return $this->apiOutput(400, 'Already unlock this submodule!');
                }

                $data = UnlockSubModule::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $unlock_sub_module_id,
                    'submit_status' => 1,
                ]);

                UserFinishedSubModules::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $request->sub_module_id,
                    'submit_status' => 1,
                ]);

                $this->apiSuccess();
                $this->data = $data;
                return $this->apiOutput(200, 'Unlock Next Submodule');
            }
        } catch (\Exception $exception) {
            return $this->apiOutput($exception->getCode(), $this->getError($exception));
        }
    }


    public function quizResult($course_id, $module_id)
    {
        try {

            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $has_enrolled_or_not = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();

            if (empty($has_enrolled_or_not)) {
                return $this->apiOutput(400, 'You are not enrolled,Please enroll first!');
            }

            $check_request_module_is_valid = CourseModule::find($module_id);
            if (empty($check_request_module_is_valid) || $check_request_module_is_valid->course_id != $course_id) {
                return $this->apiOutput(400, 'Url parameter not valid!');
            }

            $data = ResultDetails::select('user_id', 'course_id', 'user_id', 'module_id', 'total_question', 'total_correct', 'result')->where('user_id', $auth_id)->where('course_id', $course_id)->where('module_id', $module_id)->first();

            $this->apiSuccess();
            $this->data = $data;
            return $this->apiOutput(200, 'Module Quiz result');
        } catch (\Exception $exception) {
            return $this->apiOutput($exception->getCode(), $this->getError($exception));
        }
    }
}
