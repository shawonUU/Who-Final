<div class="course-container">
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-md-4">
                <div class="card px-1 py-3">
                    <img class="card-img-top img img-fluid" src="{{ $course->getImagePath($course->id) ?? '' }}"
                        alt="Card image cap" style="height:170px">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->course_title }}</h5>
                        <p class="card-text">{!! $course->course_description !!}</p>
                        <div class="content-actions">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Modules: <span>{{ $course->countModules() }}</span></h4>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="navbar float-right">
                                        <ul class="list-unstyled topnav-menu float-right mb-0">
                                            <li class="dropdown notification-list">
                                                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light"
                                                    data-toggle="dropdown" href="#" role="button"
                                                    aria-haspopup="false" aria-expanded="false">
                                                    <i class=" fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                                    <!-- item-->
                                                    <a href="{{ route('admin.course_module.index', ['course_id' => $course->id]) }}"
                                                        class="dropdown-item notify-item">
                                                        <i class="mdi mdi-plus-box-multiple-outline"></i>
                                                        <span>{{ __('Add Module') }}</span>
                                                    </a>
                                                    <!-- item-->
                                                    <a href="{{ route('admin.course.edit', ['course_id' => $course->id]) }}"
                                                        class="dropdown-item notify-item">
                                                        <i class="mdi mdi-home-edit-outline"></i>
                                                        <span>{{ __('Edit Course') }}</span>
                                                    </a>
                                                    <!-- item-->
                                                    <a href="{{ route('admin.course.show', ['course_id' => $course->id]) }}"
                                                        class="dropdown-item notify-item">
                                                        <i class="mdi mdi-eye"></i>
                                                        <span>{{ __('View') }}</span>
                                                    </a>
                                                    {!! Form::open(['route' => ['admin.course.destroy', $course->id], 'method' => 'delete']) !!}
                                                    <!-- item-->
                                                    {!! Form::button('<i class="mdi mdi-delete-alert"></i> Delete', [
                                                        'type' => 'submit',
                                                        'class' => 'dropdown-item notify-item',
                                                        'onclick' => "return confirm('Are you sure?')",
                                                    ]) !!}
                                                    {!! Form::close() !!}
                                                    <div class="dropdown-divider"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select name="content_type" id="CoursePublishStatus{{ $course->id }}"
                                        class="form-control content_typeFilter CoursePublishStatus"
                                        course-id="{{ $course->id }}" required>
                                        <option value="published"
                                            {{ $course->status == 'published' ? 'selected' : '' }}>
                                            {{ __('Published') }}</option>
                                        <option value="unpublished"
                                            {{ $course->status == 'unpublished' ? 'selected' : '' }}>
                                            {{ __('Unpublished') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
