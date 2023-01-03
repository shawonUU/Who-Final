<?php

namespace App\Http\Controllers;

use App\Http\Resources\courseDetailsResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseModule;
use App\Models\SubModule;
use App\Models\UnlockModule;
use App\Models\UnlockQuiz;
use App\Models\UnlockSubModule;
use App\Models\UserFinishedSubModules;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoFrameController extends Controller
{
    public function index(Request $request)
    {
        $modules = CourseModule::orderBy('id', 'asc')->get();
        $quiz = false;
        return view('users.video_frame.index', compact('modules', 'quiz'));
    }

    public function modulePlayer(Request $request, $module_id, $sub_module_id, $type = 'video', $btn_type="next")
    {
        
        // dd('test');
        $module = CourseModule::find($module_id);

        if (empty($module)) {
            Toastr::error('Can not found this content!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        $sub_module = SubModule::find($sub_module_id);

        if (empty($sub_module)) {
            Toastr::error('Can not found this content!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        if (!$sub_module->sub_module_unlock_status()) {
            Toastr::error('You are not eligible for this sub module!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        $module                = CourseModule::find($module_id);
        $sub_module_ids        = SubModule::where('module_id', $module_id)->orderBy('id','asc')->pluck('id')->toArray();
        $last_sub_module_index     = count($sub_module_ids) - 1;
        $fisrt_sub_module_index    = 0;
        $present_sub_module_index  = array_search($sub_module_id, $sub_module_ids);
        
        if( $present_sub_module_index == $last_sub_module_index && $btn_type == 'prev' ){
                return redirect()->route('user.quizes.quizPage',['course_id'=>$module->course_id,'module_id'=>$module_id]);
        }

        $previous_index        = $present_sub_module_index - 1;
        $next_index            = $present_sub_module_index + 1;

        $previous_content      = $previous_index < 0 ? $this->getPreviousIfExist($module_id) : SubModule::find($sub_module_ids[$previous_index]);
        $next_content          = $next_index > $last_sub_module_index ? null : SubModule::find($sub_module_ids[$next_index]);
        $present_content       = $sub_module;

        $quiz                  = false;

        $course_details = Course::with(['course_modules', 'course_modules.sub_modules'])->where('id', $module->course_id)->first();
        $course         = (new courseDetailsResource($course_details));

        return view('users.video_frame.index', compact('module', 'quiz', 'present_content', 'previous_content', 'next_content', 'module','course'));
    }


    public function getPreviousIfExist($module_id)
    {
        $module = CourseModule::find($module_id);
        $course_id = $module->course_id ?? 1;

        $module_ids            = CourseModule::where('course_id', $module->course_id)->pluck('id')->toArray();

        $present_module_index  = array_search($module_id, $module_ids);
        $previous_module_index = $present_module_index - 1;

        $previous_content      = $previous_module_index < 0 ? null : SubModule::where('module_id', $module_ids[$previous_module_index])->orderBy('id', 'desc')->first();
        return $previous_content ?? null;
    }

    public function unlock_next_content(Request $request)
    {
        // return response()->json(['status' => 'failed', 'errors' => ['is it ok?']]);
        try {
            $auth_id = Auth::id();

            if (empty($auth_id)) {
                return response()->json(['status' => 'failed', 'errors' => ['Please Login as a User!']]);
            }

            $sub_module = SubModule::find($request->current_sub_module_id);
            if (empty($sub_module)) {
                return response()->json(['status' => 'failed', 'errors' => ['Submodule not found!']]);
            }

            $module_id = $sub_module->module_id ?? null;
            $module = CourseModule::find($module_id);

            if (empty($module)) {
                return response()->json(['status' => 'failed', 'errors' => ['Module not found!']]);
            }

            $has_unlock = UnlockModule::where('user_id', $auth_id)->where('module_id', $module_id)->first();
            if (empty($has_unlock)) {
                return response()->json(['status' => 'failed', 'errors' => ['You had no permission!']]);
            }

            $course_id = $module->course_id ?? null;

            $has_enroll_this_course = CourseEnrollment::where('user_id', $auth_id)->where('course_id', $course_id)->first();
            if (empty($has_enroll_this_course) && !empty($auth_id)) {
                return response()->json(['status' => 'failed', 'errors' => ['You have to enrolled first!']]);
            }

            $check_already_finish = UserFinishedSubModules::where('user_id', $auth_id)->where('sub_module_id', $request->current_sub_module_id)->first();
            if (!empty($check_already_finish) && !empty($auth_id)) {
                return response()->json(['status' => 'failed', 'errors' => ['Already finished this submodule!']]);
            }

            if ($request->content_type == 'quiz') {

                $has_already_unlock = UnlockQuiz::where('user_id', $auth_id)->where('course_id', $course_id)->where('module_id', $module_id)->first();
                if (!empty($has_already_unlock)) {
                    return response()->json(['status' => 'failed', 'errors' => ['Already unlock next quiz']]);
                }
                $unlockQ = UnlockQuiz::create([
                    'user_id' => $auth_id,
                    'course_id' => $course_id,
                    'module_id' => $module_id,
                    'quiz_unlock_status' => 1,
                ]);

                UserFinishedSubModules::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $request->current_sub_module_id,
                    'submit_status' => 1,
                ]);
            } else {
                $unlock_sub_module_id = $request->next_sub_module_id ?? null;
                if ($unlock_sub_module_id == null) {
                    return response()->json(['status' => 'failed', 'errors' => ['Invalid next submodule']]);
                }
                $check_request_sub_module_is_valid = SubModule::find($unlock_sub_module_id);
                if (empty($check_request_sub_module_is_valid) || $check_request_sub_module_is_valid->module_id != $module_id) {
                    return response()->json(['status' => 'failed', 'errors' => ['Invalid module']]);
                }

                $has_already_unlock = UnlockSubModule::where('user_id', $auth_id)->where('sub_module_id', $unlock_sub_module_id)->first();

                if (!empty($has_already_unlock)) {
                    return response()->json(['status' => 'failed', 'errors' => ['Already unlock this submodule']]);
                }

                $data = UnlockSubModule::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $unlock_sub_module_id,
                    'submit_status' => 1,
                ]);

                UserFinishedSubModules::create([
                    'user_id' => $auth_id,
                    'sub_module_id' => $request->current_sub_module_id,
                    'submit_status' => 1,
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'congratualation! You have completed a module successfully!']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'errors' => [$exception->getMessage()]]);
        }
    }
}
