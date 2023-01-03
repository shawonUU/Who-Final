<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseResource;
use App\Traits\UploadFileTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CourseResourceController extends Controller
{
    use UploadFileTrait;

    public function index()
    {
        $course_resources = CourseResource::orderBy('id', 'desc')->paginate(10);
        $courses = Course::orderBy('id', 'desc')->pluck('course_title', 'id');
        return view('admin.course_resource.index', compact('course_resources', 'courses'));
    }

    public function store(Request $request, CourseResource $resource)
    {
        $validated = $request->validate([
            'course_id'               => 'required',
            'resource_name'           => 'required|max:255',
            'resource_path'           => 'required|max:255',
        ]);
        /**
         * @var $resource is instance of CourseResource Model
         */
        $input = $request->all();
        $input['resource_path'] = $this->uploadFile('resource_path', $request->resource_path, $resource->upload_path);
        $resource = CourseResource::create($input);

        Toastr::success('Course Resource created successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_resource.index');
    }

    public function update(Request $request, $course_resource_id)
    {
        // return $request;
        $validated = $request->validate([
            'course_id'               => 'required',
            'resource_path'           => 'required|max:255',
        ]);

        $course_resource = CourseResource::find($course_resource_id);
        if (empty($course_resource)) {
            Toastr::error('Something missing related this course!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_resource.index');
        }

        $input                   = $request->all();
        $exist_file              = $course_resource->resource_path;
        $input['resource_path']  = $this->delete_existing_and_upload_file('resource_path', $exist_file, $request->resource_path, $course_resource->upload_path);

        if (empty($input['resource_path']) || $input['resource_path'] == null) {
            unset($input['resource_path']);
        }

        $course_resource->fill($input);
        $course_resource->save();

        Toastr::success('Course Resource updated successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_resource.index');
    }

    public function destroy($course_resource_id)
    {
        $course_resource = CourseResource::find($course_resource_id);
        if (empty($course_resource)) {
            Toastr::error('Can not deleted this course!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_resource.index');
        }
        //Delete if file exist
        /*here integrate file deletion function */

        $course_resource->delete();
        Toastr::success('Resource deleted successfully!', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_resource.index');
    }
}
