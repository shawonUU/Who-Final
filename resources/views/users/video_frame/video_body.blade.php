<div class="container video-body pt-5 ml-2" style="margin: auto;">
    <div class="module-title section-title"
        style="width:auto; height:60px; margin:auto; display:block; background-color:#E5E5E5";>
        @if (!$quiz)
            <h2 class="">{{ $module->module_title }}</h2>
        @else
            <h2 class="">{{ __('Quiz Section') }}</h2>
        @endif
    </div>
    @if (!$quiz)
        @if ($present_content->content_type != 'video')
            <iframe
                src='https://view.officeapps.live.com/op/embed.aspx?src={{ $present_content->getContentPath('content_path') }}&embedded=true'
                style="height:500px; margin:auto; display:block; width:100%;"></iframe>
        @else
            <video class="video-js" id="myVideo" controls style="width:100%; height:500px; margin:auto; display:block">
                <source src="{{ $present_content->getContentPath('content_path') }}" type="video/mp4">
                </source>
            </video>
        @endif
        <div class="content-resource">
            <div class="row">
                @if ($present_content->youtube_path != null)
                    <div class="col-md-6">
                        <p class="pl-2">For better quality: <a href="{{ $present_content->youtube_path }}" target="_blank">
                           Click here
                        </a> </p>
                    </div>
                @endif
                @if ($present_content->content_resource != null)
                    <div class="col-md-6">
                        <p class="pl-2">Resource :  <a class="btn btn-sm btn-success float-right m-1 p-1" href="{{ $present_content->getContentPath('content_resource') }}">
                            {{__('Download Resource')}}
                        </a> </p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="overflow-auto" style="width:100%;height:500px; margin:auto;">
            @include('users.quizes.result')
        </div>
    @endif
</div>
