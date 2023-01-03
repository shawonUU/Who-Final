<?php

namespace App\Http\Controllers;

use App\Models\CourseEnrollment;
use App\Models\CourseModule;
use App\Models\SubModule;
use App\Models\UnlockModule;
use App\Models\UnlockSubModule;
use App\Models\UserFinishedModule;
use App\Models\UserFinishedSubModules;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseEnrollmentController extends Controller
{
    public function enrollment(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = 'user';
            $auth_id = Auth::id();
            $course_id = $request->course_id ?? null;

            if (empty($auth_id)) {
                Toastr::error('Please Login as a User!', '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            $has_already_enroll_this_course = CourseEnrollment::where('user_type', $type)->where('user_id', $auth_id)->where('course_id', $course_id)->first();

            if (!empty($has_already_enroll_this_course) && !empty($auth_id)) {
                Toastr::error('ALready enrolled!', '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }

            $first_module_and_sub_module = $this->get_first_module_and_sub_module($course_id);

            if ($first_module_and_sub_module['first_module_id'] == null || $first_module_and_sub_module['first_sub_module_id'] == null) {
                Toastr::error('Course not prepared!', '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            CourseEnrollment::create([
                'user_id' => $auth_id,
                'user_type' => $type,
                'course_id' => $course_id,
                'last_visit' => Carbon::now(),
            ]);



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

            Toastr::success('Enrollment successfull', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
            Toastr::error('Enrollment unsuccessfull', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function get_first_module_and_sub_module($course_id)
    {

        $data = [];

        $first_module  = CourseModule::where('course_id', $course_id)->orderBy('id', 'asc')->first();
        $first_sub_module  = SubModule::where('module_id', $first_module->id ?? null)->orderBy('id', 'asc')->first();

        $data['first_module_id'] = $first_module->id ?? null;
        $data['first_sub_module_id'] = $first_sub_module->id ?? null;

        return $data;
    }
}
