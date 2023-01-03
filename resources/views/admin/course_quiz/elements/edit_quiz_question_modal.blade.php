<form class="cmxform form-horizontal tasi-form" method="post" action="{{route('admin.quiz_question.update',['quiz_question_id'=>$quizQuestionInfo->id])}}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="radio" name="type"> <!--hidden Input  --> 
    {{-- <input type="text" value="{{ $course_id }}" name="course_id"/> <!--hidden Input  --> --}}
    {{-- <input type="text" value="{{ $module_id }}" name="module_id"/> <!--hidden Input --> --}}
    <div class="form-group row">
        <label for="question_title" class="col-form-label col-lg-4">Question Title</label>
        <div class="col-lg-8">
            @if($quizQuestionInfo->type != 'gaps')
            <input type="text" name="question_title" class="form-control" value="{{ $quizQuestionInfo->question_title }} ">
            @else
            <textarea class="form-control gap_text_question" rows="5" id="gap_text" name="question_title">{{ $quizQuestionInfo->question_title ?? $quizQuestionInfo->question_title }}</textarea>
            @endif
        </div>
    </div>
    
    
   
    <hr>
    <div class="form-group row ">
        <div class="form-group col-md-12 text-center">
            <button class="col-12 btn btn-success btn-md" type="submit">Submit</button>
        </div>
    </div>
</form>
