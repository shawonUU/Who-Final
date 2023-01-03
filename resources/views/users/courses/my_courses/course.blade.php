<div class="container row align-items-center m-1" style="min-height: 500px;">
    @forelse ($my_courses as $key=>$course )
        <div class="col-md-4">
            <div class="card" style="width: 22rem;">
                <img class="card-img-top img img-fluid" src="{{ $course->getImagePath($course->id) ?? '' }}"
                    alt="Card image cap">
                <div class="card-body">
                    <h2 class="card-title"> {{ $course->course_title }}</h2>
                    <h5>{{ __('Total Module') }} <span> {{ count($course->course_modules) ?? 0 }} </span> </h5>
                    <div class="course-button">
                        @if (Auth::check() || Auth::guard('admin')->check())
                            @auth('web')
                                <a href="{{ route('user.course.details', ['course_id' => $course->id]) }}"
                                    class="btn btn-primary"> {{ __('Go to course') }} </a>
                            @endauth

                            @auth('admin')
                                <a href="{{ route('user.course.details', ['course_id' => $course->id]) }}"
                                    class="btn btn-primary"> {{ __('Go to course') }} </a>
                            @endauth
                        @endif
                        @include('auth.login_modal')
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <h3 class="text-center text-white">No course available!</h3>
        </div>
    @endforelse
</div>
