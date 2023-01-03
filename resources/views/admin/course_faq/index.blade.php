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
                    <h1>{{__('Course FAQ')}}</h1>
                </div>
                <div class="col col-sm-6 mt-2">
                    <button type="button" class="btn btn-info btn-sm ml-1 float-right" data-toggle="modal" data-target="#courseFAQCreateModal">
                        {{__('Add FAQ')}}
                    </button>
                </div>
            </div>
        </div>
        @include('admin.course_faq.elements.faq_create_modal')
    </section>
    <section class="error-section">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>
    <div class="form-contents-table">

        {{-- @include('components.search_bar_box', ['action' => 'CenterTypeController@index', 'button' => 'Search']) --}}

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.course_faq.table')
                @include('components.paginate', ['records' => $course_faqs])
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