@extends('layouts.users.app')
@section('style')
<style>
    .fill-in-the-gaps {
    outline: 0;
    border-width: 0 0 2px;
    border-color: #797979;
  }
  .fill-in-the-gaps:focus {
    border-color: green
  }
</style>
@endsection
<?php $auth = Auth::guard('admin')->user() ?>
@section('content')
{{-- {{ dd($quizes) }} --}}
    {{-- <div class="container-fluid">
        <div class="section-title">
            <h2>Quiz</h2>
        </div>
    </div> --}}
    <div class="form-contents-table">
        <div class="card">
            <div class="card-body p-0">
                @include('users.quizes.content')
            </div>
        </div>
    </div>

@endsection

@push('script')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function calculateResult(optionCorrectStatus,questionID){
        if(optionCorrectStatus){
            var input = "input[name="+"'results["+questionID+"]']";
            $( input ).val(1);
            console.log( input);
            console.log(questionID);
        }else{
            var input = "input[name="+"'results["+questionID+"]']";
            $( input ).val(0);
            console.log( input );
            console.log(questionID);
        }
    }
</script>

<script>
    $('#course_quiz_modal_form').on('submit', function(e) {
        e.preventDefault();
        var url = "{{route('user.quizes.submission')}}"
        var formData = new FormData(this);
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                console.log(data);
                if (data.status === 'success'){
                   if(data.rate >=80){
                    Swal.fire({
                        title: '<strong>Congratulation!</strong>',
                        icon: 'success',
                        html:
                            '<h4>Quiz has been submitted</h4>' +
                            '<p> Your result : '+data.total_mark+'/'+data.total_question+'<br>'+
                                'Your score percentage : '+data.rate+'<br>'+
                            '<a href="//who.elearning.rultest.com">Unlock next module</a> ' +
                            'Thanks!</p>',
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                        })
                   }else{
                    Swal.fire({
                        title: '<strong>OMG!</strong>',
                        icon: 'error',
                        html:
                            '<h4>Quiz has been submitted</h4>' +
                            '<p> Your result : '+data.total_mark+'/'+data.total_question+'<br>'+
                            'Your score percentage : '+data.rate+'<br>'+
                            '<a href="//who.elearning.rultest.com">Retake</a> ' +
                            'Thanks!</p>',
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                        })
                   }
                    $('#course_quiz_modal_form')[0].reset();
                } else {
                    Swal.fire({
                        title: '<strong>Oopss..!</strong>',
                        text: data.message,
                        icon: 'error',
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                        })
                    $('#course_quiz_modal_form')[0].reset();
                }
            },
            error: function(data) {
                console.log(data);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    footer: '<a href="">Why do I have this issue?</a>'
                    })
            }
        });
    });
</script>
    
@endpush





