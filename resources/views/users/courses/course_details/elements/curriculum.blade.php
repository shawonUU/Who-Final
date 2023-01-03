<div class="module">
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
                              <h2><a href="{{ route('module.video_payer',['module_id'=>$module->id,'sub_module_id'=>$sub_module->id,'type'=>$sub_module->content_type]) }}" alt="module_player_link" >{{ $sub_module->content_title }} </a></h2>
                        </li>
                        @endforeach
                        <!--  Quiz Section -->
                        <li style="list-style-type: none">
                              <h2><a href="{{ route('user.quizes.quizPage',['course_id'=>$module->course_id,'module_id'=>$module->id ]) }}"> {{ strtoupper('Take Quiz') }} </a></h2>
                        </li>
                     </ul>
                </div>
          </div>
            @endforeach 
      </div>
</div>