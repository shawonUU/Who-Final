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
                    <h1>{{__('Create Course')}}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content-page-create">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">

            {!! Form::open(['route' => 'admin.course.store', 'files' => true]) !!}

            <div class="card-body">

                <div class="row">
                    @include('admin.course.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.course.index') }}" class="btn btn-default">{{__('Cancel')}}</a>
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