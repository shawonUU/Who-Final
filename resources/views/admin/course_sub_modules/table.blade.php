<div class="table-responsive">
    <table class="table table-striped subModuleDataTable" id="centerTypes-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Course Module</th>
                <th>Type</th>
                <th>Sub Module Title</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($course_sub_modules as $key => $course_sub_module)
            <tr>
                <td>{{ (((request('page') ?: 1)-1)*10)+$key+1 }}</td>
                <td>{{ $course_sub_module->module->module_title }}</td>
                <td>{{ $course_sub_module->content_type }}</td>
                <td>{{ $course_sub_module->content_title }}</td>
                <td>{!! $course_sub_module->status_buttons() !!}</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.course_sub_module.destroy', $course_sub_module->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseEditModal{{$course_sub_module->id}}">
                            <i class="fa fa-solid fa-pen" title="View"></i>
                        </button> --}}
                        {{-- <a href="{{ route('admin.course_sub_module.create',['course_sub_module_id'=>$course_sub_module->id]) }}" class="btn btn-info btn-sm ml-1"> <i class="fa fa-duotone fa-folder" title="Add Content"></i></a>                      --}}
                        <button type="button" class="btn btn-info btn-sm ml-1 subModuleEdit" value="{{ $course_sub_module->id }}">
                            <i class="fa fa-solid fa-pen" title="Edit"></i>
                        </button>
                        {!! Form::button('<i class="fa fa-solid fa-trash" title="Trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
          
        @endforeach
        @include('admin.course_sub_modules.elements.edit_modal')
        </tbody>
    </table>
</div>
