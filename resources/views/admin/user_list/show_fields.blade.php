<!-- userName Field -->
<div class="col-sm-6">
    {!! Form::label('user_name', 'User Name:') !!}
    <p>{{ $user->user_name }}</p>
</div>

<!-- User Full Name -->
<div class="col-sm-6">
    {!! Form::label('name', 'Full Name:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- User Full Name -->
<div class="col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $user->status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $user->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $user->updated_at }}</p>
</div>

