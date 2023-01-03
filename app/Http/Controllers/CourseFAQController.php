<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFaq;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CourseFAQController extends Controller
{
    public function index()
    {
        $course_faqs = CourseFaq::orderBy('id', 'asc')->paginate(10);
        $courses = Course::orderBy('id', 'desc')->pluck('course_title', 'id');
        return view('admin.course_faq.index', compact('course_faqs', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'                  => 'required',
            'course_faq_title'           => 'required|max:255',
            'course_faq_description'     => 'required',
        ]);
        CourseFaq::create([
            'course_id'                  => $request->course_id,
            'course_faq_title'           => $request->course_faq_title,
            'course_faq_description'     => $request->course_faq_description,
        ]);

        Toastr::success('Course FAQ created successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_faq.index');
    }

    public function update(Request $request, $course_faq_id)
    {
        $validated = $request->validate([
            'course_id'                  => 'required',
            'course_faq_title'           => 'required|max:255',
            'course_faq_description'     => 'required',
        ]);

        $course_faq = CourseFaq::find($course_faq_id);
        if (empty($course_faq)) {
            Toastr::error('Something missing related this course mFAQ!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_faq.index');
        }

        $course_faq->course_id                = $request->course_id;
        $course_faq->course_faq_title         = $request->course_faq_title;
        $course_faq->course_faq_description   = $request->course_faq_description;
        $course_faq->save();


        Toastr::success('Course FAQ updated successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_faq.index');
    }

    public function destroy($course_faq_id)
    {
        $course_faq = CourseFaq::find($course_faq_id);
        if (empty($course_faq)) {
            Toastr::error('Course FAQ can not found', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.course_faq.index');
        }

        $course_faq->delete();

        Toastr::success('Course FAQ deleted successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.course_faq.index');
    }
}
