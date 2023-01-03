@extends('layouts.app')
@section('style')
 <!-- include summernote css/js -->
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Course</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="content-page-edit">
        <div class="card">
            {!! Form::model($course, ['route' => ['admin.course.update', $course->id], 'files'=>true, 'method' => 'post']) !!}
            <div class="card-body">
                <div class="row">
                    @include('admin.course.fields')
                </div>
            </div>
           {!! Form::close() !!}
        </div>
    </div>
@endsection


@push('script')
 <!-- include summernote css/js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    
@endpush