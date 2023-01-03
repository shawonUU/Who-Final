<div class="cycle-tab-container p-5 mb-5" >
   <div class="row">
      <div class="col-md-9">
      <div class="accordian">
        <div class="section-title">
          <h2><span></span>{{ $course->course_title }}</h2>
        </div>
      </div>

        <ul class="nav nav-tabs" style="width: 60%;
        margin: auto;">
          <li class="cycle-tab-item tab1">
            <a class="nav-link" role="tab" data-toggle="tab" href="#description" onclick="tabChange('description')">{{ __('frontend_Description') }}</a>
          </li>
          <li class="cycle-tab-item tab2 active">
            <a class="nav-link" role="tab" data-toggle="tab" href="#curriculum"  onclick="tabChange('curriculum')">{{ __('frontend_Curriculum') }}</a>
          </li>
          <li class="cycle-tab-item tab3">
            <a class="nav-link" role="tab" data-toggle="tab" href="#faq"  onclick="tabChange('faq')">{{ __('frontend_Learning Objectives') }}</a>
          </li>
        </ul>
          <div class="tab-content pt-2 mb-2">
            <div class="tab-pane fade tab-content1" id="description" role="tabpanel" aria-labelledby="description-tab">
               @include('users.courses.course_details.elements.description')
            </div>
            <div class="tab-pane fade tab-content2 active" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
              @include('users.courses.course_details.elements.curriculum')
            </div>
            <div class="tab-pane fade tab-content3" id="faq" role="tabpanel" aria-labelledby="faq-tab">
              @include('users.courses.course_details.elements.faq')
            </div>
          </div>
      </div>
      <div class="col-md-3 mt-4 mb-1">
        <div class="div text-center border rounded mb-3" style="background: #31D2F2; height:60px;">
            <a href="{{route('module.video_payer',['module_id'=>$course->course_modules[0]->id,'sub_module_id'=>$course->course_modules[0]->sub_modules[0]->id, 'type'=>'video'])}}" class="btn text-white text-center pt-3"  style="height:40px; min-width:40%"> <b>{{ __('frontend_Start') }}</b> </a>
        </div>
        <div class="progress mx-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: {{ $course->getCompleteRate() }}%" aria-valuenow="{{ $course->getCompleteRate() }}" aria-valuemin="0" aria-valuemax="100">{{ $course->getCompleteRate() }}%</div>
        </div>
        {{-- <div class="div my-1">
            <div class="card p-3">
                <h5>
                    <a href="{{route('user.certificate.download',['course_id'=>$course->id])}}"  style="height:40px; min-width:40%">
                    <span class="float-start pr-1"><i class="fa fa-thin fa-download" style="color: #243c64"></i></span> Download Your Certificate
                     </a>
                </h5>
            </div>
        </div>--}}
        <div class="my-1">
            <div class="card p-2">
                <h6><span>{{ __('frontend_Enrolled') }} : </span> <b>{{$total_enroll}}</b> <span class="float-end pr-1"><i class="fa fa-thin fa-users" style="color: #243c64"></i></span> </h6>
                <h6><span>{{ __('frontend_Lecture') }} : </span> <b>{{count($course->course_modules)}}</b> <span class="float-end pr-1"><i class="fa fa-thin fa-bullhorn" style="color: #243c64"></i></span> </h6>
            </div>
        </div> 
      </div>
   </div>
</div>
