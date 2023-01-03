<!-- Email subject Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_subject', __('Email Subject')) !!}
    {!! Form::text('email_subject', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    <label>Email Body</label>
    <textarea class="form-control summernote" id="" name="email_body"></textarea>
</div>