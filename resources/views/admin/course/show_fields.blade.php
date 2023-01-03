<!-- COurse Field -->
<div class="col-sm-6">
    {!! Form::label('course_title', 'Course Title:') !!}
    <p>P{{ $course->course_title }}</p>
</div>

<!-- course description Field -->
<div class="col-sm-6">
    {!! Form::label('course_description', 'Course Description:') !!}
    <p>{!! $course->course_description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $course->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $course->updated_at }}</p>
</div>

