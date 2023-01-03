{{-- <div class="content-img">
    <div class="course-img" id="course-img-1" >
        <img src="{{$course->getImagePath($course->id) ?? ''}}" class="img-fluid" alt="course-image" style="height: 300px; width:100%">
    </div>
    <div class="course-description">
       {! $course->course_description !}
    </div>
</div> --}}

<div class="accordian">
    {{-- <div class="course-img" id="course-img-1" >
        <img src="{{$course->getImagePath($course->id) ?? ''}}" class="img-fluid" alt="course-image" style="height:300px; width:100%" >
    </div> --}}
    <div class="course-description">
       {!! $course->course_description !!}
    </div>
 </div>
