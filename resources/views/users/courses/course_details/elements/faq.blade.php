  <div class="accordian">
     {{-- @foreach ($course_faqs as $key=>$faq) --}}

     <div class="togglediv">
        <div class="togglediv-header mb-5">
             <h4>{{ __('frontend_Learning Objectives') }}</h4>
             {{-- @if($key == 0) --}}
               <span class="fa fa-minus"></span>
             {{-- @else
               <span class="fa fa-plus"></span>
             @endif --}}
        </div>
        <div class="togglediv-body active">
            {!! $course->course_outcome !!}
        </div>
      </div>
     {{-- @endforeach --}}
</div>
