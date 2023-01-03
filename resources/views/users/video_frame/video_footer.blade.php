<div class="video-footer my-3" style="width:100%; height:100px;margin:auto; display:block; background-color:#24D294;">
    <div class="row pt-3">
        <div class="prev-content col-4 text-lg-left pt-3">
            @if ($previous_content != null)
                <a class="btn text-white"
                    href="{{ route('module.video_payer', ['module_id' => $previous_content->module_id, 'sub_module_id' => $previous_content->id, 'type' => $previous_content->content_type,'btn_type'=>'prev']) }}"
                    role="button"><i class="fa fa-light fa-chevron-left"></i> Prev</a>
            @endif
        </div>
        <div class="present-content col-4 text-lg-center pt-3">
            @if ($present_content->sub_module_finish_status())
                <a class="btn  rounded-pill" href="#" role="button"
                    style="color:#24D294; background: #fff;">
                    Completed</a>
            @else
                <a class="btn  rounded-pill module_complete_status" href="#" role="button"
                    style="color:#24D294; background: #fff; display:none;"
                    timer = "{{ $present_content->timer ?? 1 }}"
                    current-sub-module-id="{{ $present_content->id }}"
                    next-content-type="@if ($next_content == null) {{ 'quiz' }} @else {{ $next_content->content_type }} @endif"
                    next-content-id="@if ($next_content == null) {{ -1 }} @else {{ $next_content->id }} @endif">
                    Complete Status</a>
                    <p class="countdown text-white" id="countdown"></p>
            @endif
        </div>
        <div class="next-content col-4 text-lg-end pt-3">
            @if ($next_content != null)
                @if ($present_content->sub_module_finish_status())
                    <a class="btn text-white " id="nextButton"
                        href="{{ route('module.video_payer', ['module_id' => $next_content->module_id, 'sub_module_id' => $next_content->id, 'type' => $next_content->content_type]) }}"
                        role="button">Next <i class="fa fa-light fa-chevron-right"></i></a>
                @else
                    <a class="btn text-white disabled" id="nextButton"
                        href="{{ route('module.video_payer', ['module_id' => $next_content->module_id, 'sub_module_id' => $next_content->id, 'type' => $next_content->content_type]) }}"
                        role="button">Next <i class="fa fa-light fa-chevron-right"></i></a>
                @endif
            @else
                @if ($present_content->sub_module_finish_status())
                    <a class="btn text-white" id="takeQuiz"
                        href="{{ route('user.quizes.quizPage', ['course_id' => $module->course_id, 'module_id' => $module->id]) }}"
                        role="button">Take Quiz <i class="fa fa-light fa-chevron-right"></i></a>
                @else
                    <a class="btn text-white disabled" id="takeQuiz"
                        href="{{ route('user.quizes.quizPage', ['course_id' => $module->course_id, 'module_id' => $module->id]) }}"
                        role="button">Take Quiz <i class="fa fa-light fa-chevron-right"></i></a>
                @endif
            @endif

        </div>
    </div>
</div>
