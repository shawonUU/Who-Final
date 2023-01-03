<div class="m-5 p-4">
    <button id="video_toggle_menue" class="start"><i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <div id="video-menu">
        @foreach ($course->course_modules as $module)
            <ul>
                @if ($module->getContentPath('video_content_path') != null)
                    <li>
                        <h2><a href="{{ route('module.video_payer', ['module_id' => $module->id, 'type' => 'video']) }}"
                                alt="module_player_link">{{ strtoupper('Video Content') }} </a></h2>
                    </li>
                @endif
                @if ($module->getContentPath('presentation_content_path') != null)
                    <li>
                        <h2><a href="{{ route('module.video_payer', ['module_id' => $module->id, 'type' => 'presentation']) }}"
                                alt="module_player_link">{{ strtoupper('Presntation Content') }} </a></h2>
                    </li>
                @endif
                @if ($module->getContentPath('text_content_path') != null)
                    <li>
                        <h2><a href="{{ route('module.video_payer', ['module_id' => $module->id, 'type' => 'text']) }}"
                                alt="module_player_link">{{ strtoupper('Text Content') }} </a></h2>
                    </li>
                @endif
            </ul>
        @endforeach
    </div>
</div>
