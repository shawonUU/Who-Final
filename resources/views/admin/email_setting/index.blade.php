@extends('layouts.app')
@section('style')
 <!-- include summernote css/js -->
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h1>{{__('Email Setting')}}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="form-contents-table">
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <h4>Email|Setting|<span>Admin, Viewer Mail:</span></h4>
            </div>
            <div class="card-body p-0">
               @include('admin.email_setting.admin_viewer_email')
            </div>
        </div>
    </div>

    <div class="form-contents-table">
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <h4>Email|Setting|<span>Hibernate Users Mail:</span></h4>
            </div>
            <div class="card-body p-0">
               @include('admin.email_setting.admin_viewer_email')
            </div>
        </div>
    </div>
   
    <div class="form-contents-table">
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <h4>Email|Setting|<span>Inactive Users Mail:</span></h4>
            </div>
            <div class="card-body p-0">
               @include('admin.email_setting.admin_viewer_email')
            </div>
        </div>
    </div>


@endsection

@push('script')
 <!-- include summernote css/js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    
@endpush

