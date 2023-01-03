<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\CourseModule;
use App\Models\CourseResult;
use App\Models\ResultDetails;
use App\Models\SubModule;
use App\Models\UnlockModule;
use App\Models\UnlockQuiz;
use App\Models\UnlockSubModule;
use App\Models\UserFinishedModule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizQuestionController extends Controller
{

    public function index(Request $request)
    {

        if ($request->query('module_id') != '' || $request->query('module_id') != null)
            $module_id = $request->query('module_id');
        $module = CourseModule::find($module_id);
        $course_id = $module->course_id ?? null;
        $course = Course::find($course_id);
        if (empty($course)) {
            Toastr::error('Course not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
        if (empty($module)) {
            Toastr::error('Module not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }

        $quiz_questions = QuizQuestion::with('options')->where('course_id', $course_id)->where('module_id', $module_id)->get();
        $courses        = Course::orderBy('id', 'desc')->pluck('course_title', 'id');
        $course_modules = CourseModule::orderBy('id', 'desc')->pluck('module_title', 'id');
        return view('admin.course_quiz.index', compact('quiz_questions', 'courses', 'course_modules', 'course_id', 'module_id'));
    }
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'course_id'                   => 'required',
                'module_id'                   => 'required',
                'question_title'              => 'required',
                'type'                        => 'required',
            ]);
            $type = $request->type ?? 'radio';

            $question = QuizQuestion::create([
                'course_id'                   => $request->course_id,
                'module_id'                   => $request->module_id,
                'question_title'              => $request->question_title,
                'type'                        => $type,
            ]);

            $length = count($request->option_text);

            for ($i = 0; $i < $length; $i++) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'option_text' => $request->option_text[$i],
                    'correct_answer' => $request->correct_answer[$i],
                ]);
            }

            DB::commit();
            Toastr::success('Quiz Question created successfull', '', ["positionClass" => "toast-top-right"]);
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            // return $exception;
            Toastr::error('Quiz Question created unsuccessfull!', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
    }

    public function edit_form(Request $request)
    {
        $quizQuestionInfo = QuizQuestion::find($request->quiz_question_id);
        $courses          = Course::orderBy('id', 'desc')->pluck('course_title', 'id');
        return view('admin.course_quiz.elements.edit_quiz_question_modal', compact('quizQuestionInfo', 'courses'));
    }

    public function update(Request $request, $quiz_question_id)
    {
        $validated = $request->validate([
            'question_title'              => 'required',
            'type'                        => 'required',
        ]);

        $quiz_question = QuizQuestion::find($quiz_question_id);
        if (empty($quiz_question)) {
            Toastr::error('Quiz question not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }

        if ($request->type == 'radio' || $request->type == 'checkbox') {
            $quiz_question->question_title = $request->question_title;
            $quiz_question->type = $request->type;
            $quiz_question->save();
        } else {
            $quiz_question->course_id = $request->course_id;
            $quiz_question->question_title = $request->question_title;
            $quiz_question->gap_question_text_with_blank = $request->gap_question_text_with_blank;
            // $quiz_question->gap_question_text_with_input_tag = $request->conversion_gap_text_with_input;
            $quiz_question->gap_answers = $request->gap_answers;
            $quiz_question->type = $request->type;
            $quiz_question->save();
        }

        Toastr::success('Quiz Question updated successfull', '', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function destroy($quiz_question_id)
    {

        DB::beginTransaction();
        try {
            $quiz_options = QuizOption::where('quiz_question_id', $quiz_question_id)->get();
            foreach ($quiz_options as $qo) {
                $qo->delete();
            }
            $quiz_question = QuizQuestion::find($quiz_question_id);
            if (empty($quiz_question)) {
                Toastr::error('Already deleted', '', ["positionClass" => "toast-top-right"]);
                return redirect()->route('admin.quiz_question.index');
            }
            $quiz_question->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Question Removed Successfully!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function quiz($course_id, $module_id)
    {
        $has_access = UnlockQuiz::where('user_id', Auth::id())->where('course_id', $course_id)->where('module_id', $module_id)->first();
        if (empty($has_access)) {
            Toastr::error('You are not eligible for this quiz!', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
           $has_result = ResultDetails::where('user_id', Auth::id())->where('course_id', $course_id)->where('module_id', $module_id)->first();
        if(empty($has_result)){
            $quizes = QuizQuestion::with(['options'])->where('course_id', $course_id)->where('module_id', $module_id)->get()->shuffle();
            return view('users.quizes.index', compact('quizes', 'module_id'));
        }else{
            $result_details = $has_result;
            $quiz = true;
            $module_ids = CourseModule::where('course_id',$course_id)->orderBy('id','asc')->pluck('id')->toArray();
            $SubModule = SubModule::where('module_id',$module_id)->orderBy('id','desc')->first();
            $prev_content = route('module.video_payer',['module_id'=>$SubModule->module_id,'sub_module_id'=>$SubModule->id,'type'=>$SubModule->content_type]);
            $current_module_index = array_search($module_id,$module_ids);
            $last_index = count($module_ids) - 1;
            $next_module_index = $current_module_index >= $last_index ? null : $current_module_index + 1;

            if( $next_module_index == null ){
                $next_content = route('user.course.details',['course_id'=>$course_id]);
            }else{
                $next_sub_module = SubModule::where('module_id',$module_ids[$next_module_index])->orderBy('id','asc')->first();
                $next_content = route('module.video_payer',['module_id'=>$next_sub_module->module_id,'sub_module_id'=>$next_sub_module->id,'type'=>$next_sub_module->content_type]);
            }

            return view('users.quizes.result', compact('result_details','quiz','prev_content','next_content'));
        }
    }

    public function quizSubmission(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $total_question = count($request->questions);
            $total_right_ans = $this->get_count_of_total_right_ans($request->results, $request->questions);
            $rating          = (($total_right_ans * 100) / $total_question);

            if ($rating < 80) {
                return response()->json(['status' => 'success', 'message' => 'You can not pass this module', 'rate' => $rating, 'total_question' => $total_question, 'total_mark' => $total_right_ans]);
            }
            $module_id = $request->module_id ?? null;
            if (empty($module_id)) {
                return response()->json(['status' => 'failed', 'message' => 'Module can not found']);
            }
            $module = CourseModule::find($request->module_id);
            $course_id = $module->course_id;
            $auth_id = Auth::id();

            if (empty($auth_id)) {
                return response()->json(['status' => 'failed', 'message' => 'You are unauthorized']);
            }

            $has_enroll = CourseEnrollment::where('course_id', $course_id)->where('user_id', $auth_id)->first();
            if (empty($has_enroll)) {
                return response()->json(['status' => 'failed', 'message' => 'You can not submit. Please Enroll this course first']);
            }

            $already_submit_same_module = ResultDetails::where('user_id', $auth_id)->where('course_id', $course_id)->where('module_id', $module_id)->first();
            if (!empty($already_submit_same_module)) {
                return response()->json(['status' => 'failed', 'message' => 'Already Submited']);
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
            $next_module_and_submodule = $this->getNextModuleAndSubmoduleThatNeedToUnlock($course_id, $module_id);

            if ($next_module_and_submodule['next_module_id'] != null) {
                UnlockModule::create([
                    'user_id' => $auth_id,
                    'module_id' => $next_module_and_submodule['next_module_id'],
                    'submit_status' => 1,
                ]);


                if ($next_module_and_submodule['next_sub_module_id'] != null) {
                    UnlockSubModule::create([
                        'user_id' => $auth_id,
                        'sub_module_id' => $next_module_and_submodule['next_sub_module_id'],
                        'submit_status' => 1,
                    ]);
                }
            }

            UserFinishedModule::create([
                'user_id' => $auth_id,
                'module_id' => $module_id,
                'submit_status' => 1,
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'You pass the module', 'rate' => $rating, 'total_question' => $total_question, 'total_mark' => $total_right_ans]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function get_count_of_total_right_ans($results, $questions)
    {
        $correct = 0;
        $len = count($questions);
        for ($i = 0; $i < $len; $i++) {
            if ($results[$questions[$i]])
                $correct++;
        }
        return $correct;
    }

    public function getNextModuleAndSubmoduleThatNeedToUnlock($course_id, $module_id)
    {
        $module_ids = CourseModule::where('course_id', $course_id)->pluck('id')->toArray();
        $length = count($module_ids);
        $current_index = array_search($module_id, $module_ids);
        $next_module_index    = ($current_index + 1) >= $length ? null : $current_index + 1;
        if ($next_module_index == null) {
            $data['next_module_id'] = null;
            $data['next_sub_module_id'] = null;
        } else {
            $data['next_module_id'] = $module_ids[$current_index + 1] ?? null;
            $SubModule = SubModule::where('module_id', $module_ids[$current_index + 1])->orderBy('id', 'asc')->first();
            $data['next_sub_module_id'] = $SubModule->id ?? null;
        }
        return $data;
    }
}
