<div class="table-responsive">
    <table class="table table-striped" id="admins-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}</th>
                <th>{{ __('Full Name') }}</th>
                 <th>{{ __('Phone') }}</th>
                <th>{{ __('Date of Registration') }}</th>
                <th>{{ __('Last active Date') }}</th>
                <th>{{ __('Gaps( Days )') }}</th>
                {{-- <th>{{ __('Details') }}</th> --}}
                <th colspan="3">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->last_login_at }}</td>
                <td>{{ Carbon\Carbon::parse($user->last_login_at)->diffInDays(Carbon\Carbon::now()) }} Days</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.user.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.user.show', [$user->id]) }}" class='btn btn-success btn-sm'>
                            <i class="fa fa-solid fa-eye" title="View"></i>
                        </a>
                        {{-- <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#userEditModal{{$user->id}}">
                            <i class="fa fa-solid fa-pen" title="Edit"></i>
                        </button> --}}
                        {!! Form::button('<i class="fa fa-solid fa-trash" title="Trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                    @if(!$user->has_any_banned_record)
                        {!! Form::open(['route' => ['admin.user.banned', $user->id], 'method' => 'get']) !!}
                        <div class='btn-group m-1'>
                            {!! Form::button('<i class="fa fa-solid fa-ban" title="Ban"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure, you want to banned this user?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['admin.user.un-banned', $user->id], 'method' => 'get']) !!}
                        <div class='btn-group m-1'>
                            {!! Form::button('<i class=" fas fa-check-circle" title="Remove Ban"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure, you want to banned this user?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
            @include('admin.user_list.elements.user_edit')
        @endforeach
        </tbody>
    </table>
</div>
