<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}    
</div>

<!-- Phone Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
        {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}    
</div> --}}

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:(set if you want to change') !!}
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255, 'autocomplete' => 'new-password']) !!}
</div>
<input type="hidden" name="type" value="{{ request()->query('type') }}"/>

{{-- <div class="form-group col-sm-6">
    <strong>Type:</strong>
    {!! Form::select('roles[]', $roles, $userRole, array('class' => 'form-control')) !!}
</div> --}}
