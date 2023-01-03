@section('style')
@endsection
<div class="card mt-5 pt-1">
         <div class="section-title">
            <h2>{{ __('Content Details') }}</h2>
            {{-- <p>The course is composed of Seven modules:</p> --}}
          </div>
          {{-- {{  $course->getCompleteRate() }} --}}
          <div class="progress mx-2">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $course->getCompleteRate() }}%" aria-valuenow="{{ $course->getCompleteRate() }}" aria-valuemin="0" aria-valuemax="100">{{ $course->getCompleteRate() }}%</div>
          </div>

   <div class="module py-3 mb-3">
      <div class="accordian-custom">
            @foreach ($course->course_modules as $key=>$module )
            <div class="togglediv-custom">
                <div class="togglediv-header-custom">
                     <h6>{{ $module->module_title ?? '' }}</h6>
                     @if($module->module_unlock_status())
                       {{-- <span class="fa-solid fa-unlock"></span> --}}
                       <span class="fa fa-solid fa-lock-open"></span>
                     @else
                      <span class="fa-solid fa-lock"></span>
                     @endif
                </div>
                <div class="togglediv-body-custom active">
                     <ul>
                        @foreach($module->sub_modules as $key=>$sub_module)
                        <li style="list-style-type: none">
                              <h6><a   style="color:@if( $sub_module->sub_module_finish_status() == 1 ) green @endif" href="{{ route('module.video_payer',['module_id'=>$module->id,'sub_module_id'=>$sub_module->id,'type'=>$sub_module->content_type]) }}" alt="module_player_link" >{{ $sub_module->content_title }} </a></h6>
                        </li>
                        @endforeach
                        <!--  Quiz Section -->
                        <li style="list-style-type: none">
                              <h6><a style="color:@if( $module->quiz_finished_status($module->course_id) == 1 ) green @endif" href="{{ route('user.quizes.quizPage',['course_id'=>$module->course_id,'module_id'=>$module->id ]) }}"> {{ strtoupper('Take Quiz') }} </a></h6>
                        </li>
                     </ul>
                </div>
          </div>
            @endforeach 
      </div>
</div>
    </div>
</div>

@push('script')

@endpush
