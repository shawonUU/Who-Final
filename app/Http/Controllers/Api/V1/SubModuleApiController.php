<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\UserFinishedSubModules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubModuleApiController extends Controller
{
    public function submodule_submission($course_id, $module_id, Request $request)
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

            if (!$request->has('sub_module_id')) {
                return $this->apiOutput(400, 'sub_module_id required!');
            }
            $input                   = $request->all();
            $input['submit_status']  = 1;

            UserFinishedSubModules::create($input);
        } catch (\Exception $err) {
            return $this->apiOutput($err->getCode(), $this->getError($err));
        }
    }
}
