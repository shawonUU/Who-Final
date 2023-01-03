<div class="container row align-items-center">
    @forelse ($courses as $key=>$course )
        <div class="col-md-4">
            <div class="card mx-auto" style="width: 22rem;">
                <img class="card-img-top" src="{{ $course->getImagePath($course->id) ?? '' }}" alt="Course cover photo">
                <div class="card-body">

                    <h2 class="card-title">{{ $course->course_title }}</h2>
                    <h5>{{ __('Total Module') }} <span> {{ count($course->course_modules) ?? 0 }} </span> </h5>

                    <div class="course-button">
                        @if (Auth::check() || Auth::guard('admin')->check())
                            @auth('web')
                                <?php $user = Auth::user(); ?>
                                @if ($user->hasNotEnroll($course->id))
                                    <a href="{{ route('user.course.details', ['course_id' => $course->id]) }}"
                                        class="btn btn-primary"> {{ __('Go to course') }} </a>
                                @else
                                    <a href="{{ route('user.course.enrollment', ['course_id' => $course->id]) }}"
                                        class="btn btn-primary"> {{ __('frontend_enroll_now') }} </a>
                                @endif
                            @endauth
                        @else
                            <a href="{{ route('login', ['enroll' => true]) }}" class="btn btn-primary">
                                {{ __('frontend_enroll_now') }} </a>
                            <script>
                                function toggleMODAL() {
                                    $('#loginModal').modal('show');
                                }
                            </script>
                            @include('auth.login_modal')
                        @endif

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
