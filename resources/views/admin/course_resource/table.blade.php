<div class="table-responsive">
    <table class="table table-striped" id="centerTypes-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($course_resources as $key => $course_resource)
            <tr>
                <td>{{ (((request('page') ?: 1)-1)*10)+$key+1 }}</td>
                <td>{{ $course_resource->resource_name }}</td>
                <td><a href="{{ asset( $course_resource->upload_path ).'/'.$course_resource->resource_path }}" target="_blank" class="btn btn-sm btn-primary">View</a></td>
                <td>{!! $course_resource->status_buttons() !!}</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.course_resource.destroy', $course_resource->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseResourceEditModal{{$course_resource->id}}">
                            {{__('Edit')}}
                        </button>
                        {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @include('admin.course_resource.elements.edit_modal')
        @endforeach
        </tbody>
    </table>
</div>
