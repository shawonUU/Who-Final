<div class="card">

    {!! Form::open(['route' => 'admin.email_setting.store', 'files' => true]) !!}

    <div class="card-body">

        <div class="row">
           <input type="hidden" name="sender_type" value="hybernate"/>
           @include('admin.email_setting.elements.fields')
        </div>

    </div>

    <div class="card-footer">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('admin.course.index') }}" class="btn btn-default">{{__('Cancel')}}</a>
    </div>

    {!! Form::close() !!}

</div>