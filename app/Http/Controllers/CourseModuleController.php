<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseModule;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseModuleController extends Controller
{

    public function index(Request $request, $course_id)
    {

        $course_modules = CourseModule::orderBy('id', 'asc')->where('course_id', $course_id)->with('course')->paginate(10);
        $courses = Course::orderBy('id', 'asc')->pluck('course_title', 'id');
        return view('admin.course_module.index', compact('course_modules', 'courses', 'course_id'));
    }

    public function create($course_id)
    {
        return view('admin.course_module.create', compact('course_id'));
    }

    public function store(Request $request)
    {
        // return $request;
        // DB::beginTransaction();
        try {
            $validated = $request->validate([
                'course_id'                     => 'required',
                // 'module_title'                  => 'required|max:255',          
            ]);

            $module_titles = $request->module_title ?? [];
            $length = count($request->module_title);
            for ($i = 0; $i < $length; $i++) {
                CourseModule::create([
                    'course_id'                     => $request->course_id,
                    'module_title'                  => $module_titles[$i],
                ]);
            }

            // DB::commit();
            Toastr::success('Module created successfull', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_module.index', ['course_id' => $request->course_id]);
        } catch (Exception $e) {
            return $e;
            // DB::rollBack();
            Toastr::error('Enrollment unsuccessfull', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function update(Request $request, $course_module_id)
    {
        $validated = $request->validate([
            'course_id'              => 'required',
            'module_title'           => 'required|max:255',
        ]);

        $course_module = CourseModule::find($course_module_id);
        if (empty($course_module)) {
            Toastr::error('Something missing related this course module!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_module.index');
        }

        $course_module->course_id            = $request->course_id;
        $course_module->module_title         = $request->module_title;
        $course_module->save();


        Toastr::success('Course Module updated successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_module.index', ['course_id' => $request->course_id]);
    }


    public function destroy($course_module_id)
    {
        $course_module = CourseModule::find($course_module_id);
        if (empty($course_module)) {
            Toastr::error('Course Module can not found', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_module.index');
        }
        $course_id = $course_module->course_id;

        $course_module->delete();

        Toastr::success('Course Module deleted successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_module.index', ['course_id' => $course_id]);
    }

    public function details($module_id)
    {
    }
}
