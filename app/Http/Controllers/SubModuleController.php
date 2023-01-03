<?php

namespace App\Http\Controllers;

use App\Models\CourseModule;
use App\Models\SubModule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubModuleController extends Controller
{
    public function index(Request $request)
    {
        $module_id = $request->query('module_id') ?? null;
        if ($module_id == null || $module_id == '') {
            Toastr::error('Can not find any module', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
        $course_sub_modules = SubModule::orderBy('id', 'asc')->where('module_id', $module_id)->with('module')->paginate(10);
        $modules = CourseModule::orderBy('id', 'desc')->pluck('module_title', 'id');
        return view('admin.course_sub_modules.index', compact('course_sub_modules', 'modules', 'module_id'));
    }

    public function create($module_id)
    {
        return view('admin.course_sub_modules.create', compact('module_id'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
                'content_type' => 'required',
                'content_title' => 'required|max:255',
                'content' => 'mimes:mp4,ppt,pptx|required|max:2000480',
                'content_resource' => 'nullable|mimes:pdf,docs,doc,docx|max:10240',
                'content_url' => 'nullable|max:255',
                'content_duration' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->getMessageBag()
                ]);
            }
            $extension = $request->file('content')->extension();
            if ($request->content_type == 'video' && ($extension != 'mp4')) {
                return response()->json(['status' => false, 'errors' => ['You should upload mp4!']]);
            }

            if ($request->content_type == 'presentation' && ($extension != 'ppt' && $extension != 'pptx')) {
                return response()->json(['status' => false, 'errors' => ['You should upload a ppt/pptx slide!']]);
            }
            $input['module_id'] = $request->module_id;
            $input['content_type'] = $request->content_type;
            $input['content_title'] = $request->content_title;
            $input['timer'] = $request->content_duration;
            $input['youtube_path'] = $request->content_url ?? null;

            $sub_module_instace = new SubModule();
            $input['content_path'] = $sub_module_instace->uploadContent('content');
            $input['content_resource'] = request()->hasfile('content_resource') == true ? $sub_module_instace->uploadContent('content_resource') : null;

            SubModule::create($input);
            return response()->json(['status' => 'success', 'message' => 'Content created for submodule']);
            //   return redirect()->route( 'admin.course_sub_module.index',['module_id'=>$request->module_id] );
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'errors' => [$exception->getMessage()]]);
        }
    }

    public function edit($sub_module_id)
    {
        $course_sub_module = SubModule::find($sub_module_id);
        $module_id = $course_sub_module->module_id;
        return view('admin.course_sub_modules.edit_fields', compact('course_sub_module', 'module_id'));
    }

    public function update(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'module_id' => 'required',
                'content_type' => 'required',
                'content_title' => 'required|max:255',
                'content' => 'nullable|mimes:mp4,ppt,pptx|nullable|max:2000480',
                'content_resource' => 'nullable|mimes:pdf,docs,doc,docx|max:10240',
                'content_url' => 'nullable|max:255',
                'sub_module_id' => 'required',
                'content_duration' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->getMessageBag()
                ]);
            }

            $sub_module_id = $request->sub_module_id ?? null;
            if ($sub_module_id == null) {
                return response()->json(['status' => 'failed', 'errors' => ['Sub Module not found!']]);
            }

            if (request()->hasfile('content')) {

                $extension = $request->file('content')->extension();
                if ($request->content_type == 'video' && ($extension != 'mp4')) {
                    return response()->json(['status' => false, 'errors' => ['You should upload mp4!']]);
                }

                if ($request->content_type == 'presentation' && ($extension != 'ppt' || $extension != 'pptx')) {
                    return response()->json(['status' => false, 'errors' => ['You should upload a ppt/pptx slide!']]);
                }
            }

            $sub_module_instace = SubModule::find($sub_module_id);

            $input['module_id'] = $request->module_id;
            $input['content_type'] = $request->content_type;
            $input['content_title'] = $request->content_title;
            $input['timer'] = $request->content_duration;
            $input['youtube_path'] = request()->hasfile('content_resource') == true ? null : ($request->content_url ?? null);
            $input['content_resource'] = request()->hasfile('content_resource') == true ? $sub_module_instace->uploadContent('content_resource', $sub_module_instace->content_resource) : ($sub_module_instace->content_resource ?? null);


            $input['content_path'] = request()->hasfile('content') == true ? $sub_module_instace->uploadContent('content', $sub_module_instace->content_path) : $sub_module_instace->content_path;

            // $sub_module_instace->module_id =  $input['module_id'];
            // $sub_module_instace->content_type =  $input['content_type'];
            // $sub_module_instace->content_title =  $input['content_title'];
            // $sub_module_instace->youtube_path =  $input['youtube_path'];
            // $sub_module_instace->content_path =  $input['content_path'];
            // $sub_module_instace->content_resource =  $input['content_resource'];
            $sub_module_instace->update($input);

            return response()->json(['status' => 'success', 'message' => 'Content updated for submodule']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'errors' => [$exception->getMessage()]]);
        }
    }



    public function destroy($course_sub_module_id)
    {
        try {
            $course_sub_module = SubModule::find($course_sub_module_id);
            $module_id = $course_sub_module->module_id;
            if (empty($course_sub_module)) {
                Toastr::error('Already deleted!', '', ["positionClass" => "toast-top-right"]);
                return redirect()->route('admin.course_sub_module.index', ['module_id' => $module_id]);
            }

            //Delete if file exist
            /*here integrate file deletion function */

            $exist_content = $course_sub_module->content_path ?? null;
            if ($exist_content != null && file_exists(public_path() . '/' . $course_sub_module->upload_path . '/' . $exist_content)) {
                unlink(public_path() . '/' . $course_sub_module->upload_path . '/' . $exist_content); // Unlink content
            }
            $exist_resource = $course_sub_module->content_resource ?? null;
            if ($exist_resource != null && file_exists(public_path() . '/' . $course_sub_module->upload_path . '/' . $exist_resource)) {
                unlink(public_path() . '/' . $course_sub_module->upload_path . '/' . $exist_resource); // Unlink resource
            }

            $course_sub_module->delete();
            Toastr::success('Sub Module deleted', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_sub_module.index', ['module_id' => $module_id]);
        } catch (\Exception $exception) {
            return $exception;
            Toastr::error('Something wrong!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_sub_module.index', ['module_id' => $module_id]);
        }
    }
}
