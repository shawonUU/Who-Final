@extends('layouts.app')

@section('style')
 <!-- include summernote css/js -->
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h1>{{__('Course')}}</h1>
                </div>
                <div class="col col-sm-6 mt-2">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#courseCreateModal">
                        {{ __('Add New') }}
                    </button>
                    @include('admin.course.elements.create_modal')
                </div>
            </div>
        </div>
    </section>

    <div class="form-contents-table">
        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.course.content')
            </div>

        </div>
    </div>

@endsection

@push('script')
 <!-- include summernote css/js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    // $('#courseSubModuleEditModalSubmit').on('submit', function(e) {
        $(document).on('change', '.CoursePublishStatus', function() {
        var course_id = $(this).attr('course-id');
        var url = "{{route('admin.course.update.publish_status',['course_id'=> '__course_id'])}}"
        url = url.replace("__course_id", course_id);
        var status = $(this).val();
        // console.log(status);
        // console.log(url);
        // console.log(course_id);
        // return;
        $.ajax({
            url: url,
            type: "get",
            data:{ course_status : status },
            
            success: function(data) {
                console.log(data);
                if (data.status === 'success'){
                    successMessage(data.message);
                    $('.form-contents-table').load(location.href + ' .form-contents-table');
                    
                } else {
                    $.each(data.errors, function(key, value){
                    errorMessage(value);
                   })
                   $('.form-contents-table').load(location.href + ' .form-contents-table');
                }
            },
            error: function(data) {
                  errorMessage('Something Went wrong!');
                  $('.form-contents-table').load(location.href + ' .form-contents-table');
               
            }
        });
    });


    function successMessage(message) {
        Command: toastr["success"](message)

        // toastr.info('Page Loaded!');
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "100",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function errorMessage(message) {
        Command: toastr["error"](message)

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>
    
@endpush

