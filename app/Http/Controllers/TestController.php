<?php

namespace App\Http\Controllers;

use App\Http\Components\Traits\Message;
use App\Http\Resources\CourseWithModuleAndQuizResourceTest;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    use Message;
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
            $course         = (new CourseWithModuleAndQuizResourceTest($course_details));

            $this->apiSuccess();
            $this->data = $course;
            return $this->apiOutput(200, 'Course with module details!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }
}
