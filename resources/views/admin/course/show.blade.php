@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course Details</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content-page-show">
        <div class="card">
            <img class="card-img-top img img-fluid mx-auto py-3" src="{{ $course->getImagePath($course->id) ?? '' }}" alt="cover photo" style="height:220px; width:40%;">
            <div class="card-body">
                {{-- <div class="row">
                    @include('admin.course.show_fields')
                </div> --}}
                <div class="course-content">
                    <div class="course">
                        <div class="course-title-with-modules">
                            <h2>Course Title: {{ $course->course_title }}</h2>
                            <h5 class="card-title">Total Module: {{ count( $course->course_modules ) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
