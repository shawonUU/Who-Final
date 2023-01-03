@extends('layouts.app')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        
        <section class="error-section">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        <!-- Quiz View start-->
        <div class="port mb-3 mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools float-left">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button data-toggle="modal" data-target="#quiz-add-modal" class="btn btn-info btn-sm">Add Quiz</button>
                                    </li>&nbsp;
                                </ul>
                            </div>
                        </div>
                        <!-- CARD body will be here-->
                    </div>
                </div>
            </div>
            <h4>{{ __('MCQ Section') }} </h4>
            <div class="portfolioContainer row">                
                @forelse($quiz_questions as $key=>$quiz_question)
                  @if($quiz_question->type == 'radio' || $quiz_question->type == 'checkbox')
                    <div class="col-md-6 col-xl-3 webdesign illustrator">
                        <div class="gal-detail card p-2">
                            <div>
                                <h5 class="float-left font-16 mt-3">Quiz Type:
                                    <span class="border border-10">
                                        @if($quiz_question->type == 'radio')
                                            Single Input Answer
                                        @elseif($quiz_question->type == 'checkbox')
                                            Multiple Input Answer
                                        @endif
                                    </span>
                                </h5>
                                <div class="float-right button-list mt-2">
                                    <button type="button" id="deleteQuizQuestion" data-type="quiz" data-id="{{$quiz_question->id}}" class="btn btn-icon btn-sm waves-effect btn-danger"> <i class="far fa-trash-alt"></i> </button>
                                    <button type="button" id="editQuizQuestion" data-type="quiz" data-id="{{$quiz_question->id}}" class="btn btn-icon btn-sm waves-effect waves-light btn-secondary"> <i class="fa fa-wrench"></i> </button>
                                </div>
                            </div>

                            @if($quiz_question->type !== 'gaps')
                            <p><strong>Question: </strong>{{$quiz_question->question_title}}</p>
                            {{-- @else
                            <p><strong>Question: </strong>{{$quiz_question->gap_question_text_with_blank}}</p>
                            @endif --}}

                            {{-- @if($quiz_question->type !== 'gaps') --}}
                                <p>
                                    <strong>Options: </strong>
                                    <button type="button" id="addQuizQuestionOption" data-id="{{$quiz_question->id}}" class="btn btn-icon btn-sm waves-effect waves-light btn-info">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </p>
                                <ul class="row" style="list-style-type: none;">
                                    @forelse($quiz_question->options as $option)
                                        <li class="col-6">
                                            <span type="button" data-id="{{$option->id}}" class='deleteQuizQuestionOption badge badge-light-danger waves-effect waves-light'><i class="fa fa-trash"></i></span>
                                            <span type="button" id="editOptionForm" data-id="{{$option->id}}" class='badge badge-light-dark waves-effect waves-light'><i class="fa fa-wrench"></i></span>
                                            {{$option->option_text}} @if($option->correct_answer === '1') <span class='badge badge-success'>Correct</span> @endif
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            @endif
                        </div>
                      </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
        <!-- Quiz View end-->
    </div>



    <!--MODAL---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    @include('admin.course_quiz.elements.content_modals')
    <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


@endsection

@push('script')
    <script type="text/javascript">
      
    //Create Page Content => Quiz => Question's Option
    $(document).on('click', '#addQuizQuestionOption', function(e) {
        e.preventDefault();
        let quiz_question_id = $(this).data('id');
        var url = "{{ route('admin.quiz_option.create.form',['quiz_question_id' => '__quiz_question_id']) }}";
        url = url.replace("__quiz_question_id", quiz_question_id);
        $.ajax({
            url: url,
            success: function(res) {
                $('#questionEditForm').html(res);
                $('.card-title').html('Add Quiz Option');
                $('#quiz-edit-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                },'show');
            }
        });
    });


    //Create Page Content => Quiz => Question's Option Edit
    $(document).on('click', '#editOptionForm', function(e) {
        e.preventDefault();
        let option_id = $(this).data('id');
        var url = "{{ route('admin.quiz_option.edit.form',['option_id' => '__option_id']) }}";
        url = url.replace("__option_id", option_id);
        console.log(url);
        $.ajax({
            url: url,
            success: function(res) {
                $('#questionEditForm').html(res);
                $('.card-title').html('Edit Quiz Option');
                $('#quiz-edit-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                },'show');
            }
        });
    });


        //Delete Quiz Question's Option
        $(document).on('click', '.deleteQuizQuestionOption', function(e) {
        e.preventDefault();
        let option_id = $(this).data('id');
        var url = "{{ route('admin.quiz_option.destroy',['option_id' => '__option_id']) }}";
        url = url.replace("__option_id", option_id);
        Swal.fire({
            title:"Want to remove?",
            text:"After removing this option will be lost",
            type:"question",
            confirmButtonColor:"#348cd4",
            showCancelButton:!0,
            confirmButtonText:"Yes, delete it!",
            cancelButtonText:"No, cancel!",
            confirmButtonClass:"btn sa-success btn-success mt-2",
            cancelButtonClass:"btn sa-error btn-danger ml-2 mt-2",
            buttonsStyling:!1
        }).then(function(t){
            if (t.value === true){
                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    complete: function(data) {
                        if (data.responseJSON.status === 'success'){
                            window.location.reload();
                            Swal.fire({
                                title: "Deleted!",
                                text: data.responseJSON.message,
                                type: "success"
                            });
                        } else {
                            Swal.fire({
                                title: "Cancelled",
                                text: data.responseJSON.message,
                                type: "error"
                            });
                        }
                    }
                })
            } else {
                t.dismiss===Swal.DismissReason.cancel&&Swal.fire({
                    title:"Cancelled",
                    text:"Your quiz option is safe.",
                    type:"error"
                });
            }
        });
    });


    //Edit Page Content => Quiz => Question
    $(document).on('click', '#editQuizQuestion', function(e) {
        e.preventDefault();
        let quiz_question_id = $(this).data('id');
        var url = "{{ route('admin.quiz_question.edit_form',['quiz_question_id' => '__quiz_question_id']) }}";
        url = url.replace("__quiz_question_id", quiz_question_id);
        $.ajax({
            url: url,
            success: function(res) {
                $('#questionEditForm').html(res);
                $('.card-title').html('Edit Quiz');
                $('#quiz-edit-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                },'show');
            }
        });
    });

    //Delete Quiz Question
    $(document).on('click', '#deleteQuizQuestion', function(e) {
        e.preventDefault();
        let quiz_question_id = $(this).data('id');
        var url = "{{ route('admin.quiz_question.destroy',['quiz_question_id' => '__quiz_question_id']) }}";
        url = url.replace("__quiz_question_id", quiz_question_id);
        Swal.fire({
            title:"Want to remove?",
            text:"After removing this content will be lost",
            type:"question",
            confirmButtonColor:"#348cd4",
            showCancelButton:!0,
            confirmButtonText:"Yes, delete it!",
            cancelButtonText:"No, cancel!",
            confirmButtonClass:"btn sa-success btn-success mt-2",
            cancelButtonClass:"btn sa-error btn-danger ml-2 mt-2",
            buttonsStyling:!1
        }).then(function(t){
            if (t.value === true){
                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    complete: function(data) {
                        if (data.responseJSON.status === 'success'){
                            window.location.reload();
                            Swal.fire({
                                title: "Deleted!",
                                text: data.responseJSON.message,
                                type: "success"
                            });
                        } else {
                            Swal.fire({
                                title: "Cancelled",
                                text: data.responseJSON.message,
                                type: "error"
                            });
                        }
                    }
                })
            } else {
                t.dismiss===Swal.DismissReason.cancel&&Swal.fire({
                    title:"Cancelled",
                    text:"Your quiz question content is safe.",
                    type:"error"
                });
            }
        });
    });


    
    </script>
@endpush
