<div class="table-responsive">
    <table class="table table-striped" id="centerTypes-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Course Title</th>
                {{-- <th>Course Description</th> --}}
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($courses as $key => $course)
            <tr>
                <td>{{ (((request('page') ?: 1)-1)*10)+$key+1 }}</td>
                <td>{{ $course->course_title }}</td>
                {{-- <td>{!! $course->course_description !!}</td> --}}
                <td>{!! $course->status_buttons() !!}</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.course.destroy', $course->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.course.show', [$course->id]) }}" class='btn btn-success btn-sm'>
                            <i class="fa fa-solid fa-eye" title="View"></i>
                        </a>
                        <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseEditModal{{$course->id}}">
                            <i class="fa fa-solid fa-pen" title="Edit"></i>
                        </button>
                        {{-- <a href="{{ route('admin.course.edit', [$course->id]) }}" class='btn btn-warning btn-sm'>
                            Edit
                        </a> --}}
                        {!! Form::button('<i class="fa fa-solid fa-trash" title="Trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @include('admin.course.elements.edit_modal')
        @endforeach
        </tbody>
    </table>
</div>
