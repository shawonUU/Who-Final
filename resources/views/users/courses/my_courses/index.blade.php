@extends('layouts.users.app')

@section('style')
    <style>

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="section-title">
                <h2>{{ __('frontend_My Course') }}</h2>
            </div>
        </div>
    </div>

    <div class="course-content">
        <div class="course-content">
            @include('users.courses.my_courses.course')
        </div>

    </div>
@endsection

@push('script')
    <!-- include summernote css/js -->
@endpush
