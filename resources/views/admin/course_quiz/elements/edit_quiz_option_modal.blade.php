<form class="cmxform form-horizontal tasi-form" method="post" action="{{route('admin.quiz_option.update')}}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-form-label col-lg-4">Option Text</label>
        <div class="col-lg-8">
            <input type="text" name="option_text" value="{{$option->option_text}}" class="form-control" placeholder="Write option text here .." required>
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-form-label col-lg-4"></label>
        <div class="col-lg-8">
            <div class="radio radio-success form-check-inline">
                <input type="radio" id="inlineRadio1" value="1" name="correct_answer" {{$option->correct_answer === '1' ? 'checked' : ''}}>
                <label for="inlineRadio1"> Correct Answer</label>
            </div>
            <div class="radio radio-danger form-check-inline">
                <input type="radio" id="inlineRadio2" value="0" name="correct_answer" {{$option->correct_answer === '0' ? 'checked' : ''}}>
                <label for="inlineRadio2"> Wrong Answer</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row ">
        <div class="form-group col-md-12 text-center">
            <input type="hidden" value="{{$option->id}}" name="option_id" id="option_id">
            <button class="col-12 btn btn-success btn-md" type="submit">Submit</button>
        </div>
    </div>
</form>
