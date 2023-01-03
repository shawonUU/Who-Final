<?php

namespace App\Http\Controllers;

use App\Http\Resources\courseDetailsResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseFaq;
use App\Models\CourseModule;
// use App\Models\CourseResource;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\Setting;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller
{

    public function welcome($module_id)
    {

        $module = CourseModule::find($module_id);
        $course_id = $module->course_id ?? 1;

        $module_ids            = CourseModule::where('course_id', $course_id)->pluck('id')->toArray();
        $last_module_index     = count($module_ids) - 1;
        $fisrt_module_index    = 0;
        $present_module_index  = array_search($module_id, $module_ids);

        $previous_index        = $present_module_index - 1;
        $next_index            = $present_module_index + 1;

        $previous_content      = $previous_index < 0 ? null : CourseModule::find($module_ids[$previous_index]);
        $next_content_module          = $next_index > $last_module_index ? null : CourseModule::find($module_ids[$next_index]);
        $next_content_module   = null;
        if ($next_content_module == null) {
            Toastr::success('Welcome! You have finished a trial tour of our course overview!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('user.index');
        } else {
            $next_content = SubModule::where('module_id', $module_ids[$next_index])->orderby('id', 'asc')->first();
            Toastr::success('We are working on quiz. We give you an access for next module, Enjoy!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('module.video_payer', ['module_id' => $next_content->module_id, 'sub_module_id' => $next_content->id, 'type' => $next_content->content_type]);
        }
    }

    public function index(Request $request)
    {
        $courses = Course::orderBy('id', 'desc')->paginate(10);
        $course_categories = Setting::course_category();
        return view('admin.course.index', compact('courses', 'course_categories'));
    }

    public function store(Request $request, Course $course)
    {
        // return $request;
        $validated = $request->validate([
            'course_title'              => 'required|max:255',
            'cover_photo'               => 'mimes:jpeg,jpg,png|required',
            'course_description'        => 'required',
            'course_outcome'            => 'required',
        ]);

        $input                   = $request->all();
        $input['cover_photo']    = $course->uploadFile('cover_photo', $request->cover_photo);
        /** @var Course $course */
        $course = Course::create($input);


        Toastr::success('Course created successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course.index');
    }


    public function create()
    {
        $course_categories = Setting::course_category();
        return view('admin.course.create', compact('course_categories'));
    }

    public function show($course_id)
    {
        $course = Course::with('course_modules')->find($course_id);
        $course = (new CourseResource($course));
    
        return $course;
        if (empty($course)) {
            Toastr::error('Course not found!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course.index');
        }
        return view('admin.course.show', compact('course'));
    }

    public function edit($course_id)
    {
        $course = Course::find($course_id);
        if (empty($course)) {
            Toastr::error('Course not found!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course.index');
        }
        return view('admin.course.edit')->with('course', $course);;
    }

    public function update(Request $request, $course_id)
    {
        // return $request;
        $validated = $request->validate([
            'course_title'              => 'required|max:255',
            // 'cover_photo'               => 'mimes:jpeg,jpg,png',
            'course_description'        => 'required',
        ]);
        $course = Course::find($course_id);
        if (empty($course)) {
            Toastr::error('Something missing related this course!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course.index');
        }

        $input                   = $request->all();
        $exist_file              = $course->photo ?? null;
        $input['cover_photo']    = $course->delete_existing_and_upload_file('cover_photo', $exist_file, $request->cover_photo);

        if (empty($input['cover_photo']) || $input['cover_photo'] == null) {
            unset($input['cover_photo']);
        }

        $course->fill($input);
        $course->save();


        Toastr::success('Course updated successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course.index');
    }

    public function course_list()
    {
        $courses = Course::with('course_modules')->active()->orderBy('id', 'desc')->get();
        return view('users.courses.index', compact('courses'));
        // return $courses;
    }

    public function my_courses()
    {
        $user_id = Auth::id();
        $user_enroll_courses = CourseEnrollment::where('user_id', $user_id)->pluck('course_id');
        $my_courses = Course::whereIn('id', $user_enroll_courses)->get();
        return view('users.courses.my_courses.index', compact('my_courses'));
    }


    public function destroy($course_id)
    {
        try {
            $course = Course::find($course_id);
            if (empty($course)) {
                Toastr::error('Course already deleted', '', ["positionClass" => "toast-top-right"]);
                return redirect()->route('admin.course.index');
            }

            $module_ids = CourseModule::where('course_id', $course_id)->pluck('id');
            $quiz_ids   = QuizQuestion::where('course_id', $course_id)->pluck('id');

            $options = QuizOption::whereIn('quiz_question_id', $quiz_ids)->get();
            foreach ($options as $key => $option) {
                $option->delete();
            }

            $quizes = QuizQuestion::whereIn('id', $quiz_ids)->get();
            foreach ($quizes as $key => $quiz) {
                $quiz->delete();
            }

            $submodules = SubModule::whereIn('module_id', $module_ids)->get();
            foreach ($submodules as $key => $submodule) {
                $submodule->delete();
            }

            $modules = CourseModule::whereIn('id', $module_ids)->get();
            foreach ($modules as $key => $module) {
                $module->delete();
            }

            $course->delete();

            Toastr::success('Course deleted successfull', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course.index');
        } catch (Exception $e) {
            Toastr::error('Something Wrong', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course.index');
        }
    }


    public function courseDetails($course_id)
    {

        $course_details = Course::with(['course_modules', 'course_modules.sub_modules'])->where('id', $course_id)->first();
        $course         = (new courseDetailsResource($course_details));
        $course_faqs    = CourseFaq::orderBy('id', 'asc')->get();
        $total_enroll   = CourseEnrollment::where('course_id', $course_id)->count();
        return view('users.courses.course_details.index', compact('course', 'course_faqs', 'total_enroll'));
    }

    public function courseDetailsPublic($course_id)
    {
        $course_details = Course::with(['course_modules', 'course_modules.sub_modules'])->where('id', $course_id)->first();
        $course         = (new courseDetailsResource($course_details));
        $course_faqs    = CourseFaq::orderBy('id', 'asc')->get();
        $total_enroll   = CourseEnrollment::where('course_id', $course_id)->count();
        return view('users.courses.course_details.public.index', compact('course', 'course_faqs', 'total_enroll'));
    }

    public function update_status($course_id, Request $request)
    {
        try {
            $course = Course::find($course_id);
            if (empty($course)) {
                return response()->json(['status' => 'failed', 'errors' => ['Course Not found']]);
            }

            $module_ids = CourseModule::where('course_id', $course_id)->pluck('id')->toArray();
            $length = count($module_ids);
            if ($length == 0) {

                return response()->json(['status' => 'failed', 'errors' => ['Sorry! Course must have Module. please check!']]);
            }
            for ($i = 0; $i < $length; $i++) {

                $has_any_submodule = SubModule::where('module_id', $module_ids[$i])->first();
                $has_any_quiz = QuizQuestion::where('module_id', $module_ids[$i])->where('course_id', $course_id)->first();


                if (empty($has_any_quiz) || empty($has_any_submodule)) {

                    return response()->json(['status' => 'failed', 'errors' => ['Sorry! Course must have Module,Submodule & quiz. please check!']]);
                }
            }


            $course->status  = $request->course_status;
            $course->save();
            return response()->json(['status' => 'success', 'message' => 'Course Status Changed']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'errors' => [$exception->getMessage()]]);
        }
    }
}
