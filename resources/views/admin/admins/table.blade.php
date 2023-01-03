<div class="table-responsive">
    <table class="table table-striped" id="admins-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Status') }}</th>
                <th colspan="3">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->type }}</td>
                <td>
                    @if($admin->status == 'active')
                        <span class="badge badge-success">{{__('Active')}}</span>
                    @else
                        <span class="badge badge-danger">{{__('Inactive')}}</span>
                    @endif
                </td>          
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.destroy', $admin->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.show', [$admin->id]) }}" class='btn btn-success btn-sm'>
                            {{ __('View') }}
                        </a>
                        @if( $auth->type == 'admin')
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#adminEditModal{{$admin->id}}">
                            {{__('Edit')}}
                        </button>
                        {{-- <a href="{{ route('admin.edit', [$admin->id]) }}" class='btn btn-warning btn-sm'>
                            Edit
                        </a> --}}
                        @endif
                        {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                @include('admin.admins.elements.edit_modal')
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
