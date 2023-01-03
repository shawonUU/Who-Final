<div class="table-responsive">
    <table class="table table-striped" id="centerTypes-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Course Name</th>
                <th>Course Module Title</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($course_modules as $key => $course_module)
            <tr>
                <td>{{ (((request('page') ?: 1)-1)*10)+$key+1 }}</td>
                <td>{{ $course_module->course->course_title }}</td>
                <td>{{ $course_module->module_title }}</td>
                <td>{!! $course_module->status_buttons() !!}</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.course_module.destroy', $course_module->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseEditModal{{$course_module->id}}">
                            <i class="fa fa-solid fa-pen" title="View"></i>
                        </button> --}}                     
                        {{-- <a href="{{ route('admin.course_module.details',['module_id'=>$course_module->id]) }}" class="btn btn-info btn-sm ml-1"> <i class="fa fa-duotone fa-folder" title="Add Content"></i></a>                      --}}
                        <a href="{{ route('admin.course_sub_module.index',['module_id'=>$course_module->id]) }}" class="btn btn-info btn-sm ml-1"> <i class="fa fa-duotone fa-folder" title="Add Sub-module"></i></a>                     
                        <a href="{{ route('admin.quiz_question.index',['module_id'=>$course_module->id]) }}" class="btn btn-info btn-sm ml-1"> <i class="mdi mdi-arrow-all" title="Add Quiz"></i></a>
                        <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseEditModal{{$course_module->id}}">
                            <i class="fa fa-solid fa-pen" title="Edit"></i>
                        </button>
                        {!! Form::button('<i class="fa fa-solid fa-trash" title="Trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @include('admin.course_module.elements.edit_modal')
        @endforeach
        </tbody>
    </table>
</div>
