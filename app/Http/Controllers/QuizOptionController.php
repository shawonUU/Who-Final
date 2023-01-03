<?php

namespace App\Http\Controllers;

use App\Models\QuizOption;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizOptionController extends Controller
{

    public function store(Request $request)
    {
        $length = count($request->option_text);

        for ($i = 0; $i < $length; $i++) {
            QuizOption::create([
                'quiz_question_id' => $request->quiz_question_id,
                'option_text' => $request->option_text[$i],
                'correct_answer' => $request->correct_answer[$i],
            ]);
        }
        Toastr::success('Quiz Option created successfull', '', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function update(Request $request)
    {
        $quiz_option = QuizOption::find($request->option_id);

        if (empty($quiz_option) || $request->option_id == null) {
            Toastr::error('Quiz Option not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }

        $quiz_option->option_text       = $request->option_text;
        $quiz_option->correct_answer    = $request->correct_answer;
        $quiz_option->save();

        Toastr::success('Quiz Option updated', '', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function destroy($quiz_question_id)
    {
        try {
            $quiz_options = QuizOption::find($quiz_question_id);
            $quiz_options->delete();

            return response()->json(['status' => 'success', 'message' => 'Question option Removed Successfully!']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function getQuizOptionCreateForm($quiz_question_id)
    {
        return view('admin.course_quiz.elements.create_quiz_option_modal', compact('quiz_question_id'));
    }

    public function getQuizOptionEditForm($option_id)
    {
        $option = $this->getQuizOption($option_id);
        return view('admin.course_quiz.elements.edit_quiz_option_modal', compact('option'));
    }

    public function deleteQuizQuestionOption($option_id)
    {
        try {
            $quiz_option = QuizOption::find($option_id);
            $quiz_option->delete();
            return response()->json(['status' => 'success', 'message' => 'Option deleted at topic page']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    public function getQuizOption($option_id)
    {
        return QuizOption::find($option_id);
    }
}
