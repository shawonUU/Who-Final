<!-- Add Quiz Modal Start --->
<div id="quiz-add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-0 b-0">
            <div class="card card-color mb-0">
                <div class="card-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="card-title text-white mt-1 mb-0">Add Quiz</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form class="cmxform form-horizontal tasi-form" method="post" action="{{route('admin.quiz_question.store')}}" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                        
                            <input type="hidden" value="{{ $course_id }}" name="course_id"/> <!--hidden Input  -->
                            <input type="hidden" value="{{ $module_id }}" name="module_id"/> <!--hidden Input -->
                            <input type="hidden" value="radio" name="type"/> <!--hidden Input (Type of question) -->
                            <div class="form-group row">
                                <label for="question_title" class="col-form-label col-lg-4">Question Title</label>
                                <div class="col-lg-8">
                                    <input type="text" name="question_title" class="form-control" placeholder="Write question title here ..">
                                </div>
                            </div>
                            <hr/>
                          {{-- Quiz Options --}}
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
                        <div id="addOptionField"></div>
                        <button type="button" onclick="addOptionFieldFunc()" class="btn btn-sm btn-dark btn-group"> Add another option</button>
                        <hr>

                            <div class="form-group row ">
                                <div class="form-group col-md-12 text-center">
                                    <input type="hidden" value="quiz" name="content_type">
                                    <button class="col-12 btn btn-success btn-md" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal end -->

<!-- Edit Quiz Modal Start --->
<div id="quiz-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <div class="card card-color mb-0">
                <div class="card-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="card-title text-white mt-1 mb-0"></h3>
                </div>
                <div class="card-body">
                    <div class="form" id="questionEditForm">
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal end -->
<script>
    var key = 0;
    function addOptionFieldFunc() {
        console.log('clicked');
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
        document.getElementById("addOptionField").appendChild(field);
    }
</script>