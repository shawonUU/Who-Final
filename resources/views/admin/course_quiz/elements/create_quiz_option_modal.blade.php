<form class="cmxform form-horizontal tasi-form" method="post" action="{{route('admin.quiz_option.store')}}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-form-label col-lg-4">Option Text</label>
        <div class="col-lg-8">
            <input type="text" name="option_text[]" class="form-control" placeholder="Write option text here .." required>
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-form-label col-lg-4"></label>
        <div class="col-lg-8">
            <div class="radio radio-success form-check-inline">
                <input type="radio"  value="1" name="correct_answer[0]">
                <label> Correct Answer</label>
            </div>
            <div class="radio radio-danger form-check-inline">
                <input type="radio" value="0" name="correct_answer[0]">
                <label> Wrong Answer</label>
            </div>
        </div>
    </div>
    <div id="addOptionFields"></div>
    <button type="button" onclick="addOptionFieldFunc()" class="btn btn-sm btn-dark btn-group"> Add another options</button>
    <hr>
    <div class="form-group row ">
        <div class="form-group col-md-12 text-center">
            <input type="hidden" value="{{$quiz_question_id}}" name="quiz_question_id" id="quiz_question_id">
            <button class="col-12 btn btn-success btn-md" type="submit">Submit</button>
        </div>
    </div>
</form>

<script>
    var key = 0;
    function addOptionFieldFunc() {
        key++;
        var field = document.createElement('div');
        field.innerHTML = "<div class=\"form-group row\">\n" +
            "        <label for=\"name\" class=\"col-form-label col-lg-4\">Option Text</label>\n" +
            "        <div class=\"col-lg-8\">\n" +
            "            <input type=\"text\" name=\"option_text[]\" class=\"form-control\" placeholder=\"Write option text here ..\" >\n" +
            "        </div>\n" +
            "    </div>\n" +
            "    <div class=\"form-group row\">\n" +
            "        <label for=\"name\" class=\"col-form-label col-lg-4\"></label>\n" +
            "        <div class=\"col-lg-8\">\n" +
            "            <div class=\"radio radio-success form-check-inline\">\n" +
            "                <input type=\"radio\" value=\"1\" name=\"correct_answer["+key+"]\">\n" +
            "                <label> Correct Answer</label>\n" +
            "            </div>\n" +
            "            <div class=\"radio radio-danger form-check-inline\">\n" +
            "                <input type=\"radio\" value=\"0\" name=\"correct_answer["+key+"]\">\n" +
            "                <label> Wrong Answer</label>\n" +
            "            </div>\n" +
            "        </div>\n" +
            "    </div>";
        document.getElementById("addOptionFields").appendChild(field);
    }
</script>
