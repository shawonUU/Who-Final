<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $admin->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $admin->email }}</p>
</div>
<!-- Phone Field -->
{{-- <div class="col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $admin->phone }}</p>
</div> --}}

<!-- Email Verified At Field -->
{{-- <div class="col-sm-6">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    <p>{{ $admin->email_verified_at }}</p>
</div> --}}

<!-- Password Field -->
{{-- <div class="col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    <p>{{ $admin->password }}</p>
</div> --}}

<!-- Remember Token Field -->
{{-- <div class="col-sm-6">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    <p>{{ $admin->remember_token }}</p>
</div> --}}

