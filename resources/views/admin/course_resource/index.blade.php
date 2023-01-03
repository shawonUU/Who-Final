@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h1>{{__('Course Resources')}}</h1>
                </div>
                <div class="col col-sm-6 mt-2">
                    <button type="button" class="btn btn-info btn-sm ml-1 float-right" data-toggle="modal" data-target="#courseResourceCreateModal">
                        {{__('Add Resource')}}
                    </button>
                </div>z
            </div>
        </div>
        @include('admin.course_resource.elements.resource_create_modal')
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
                @include('admin.course_resource.table')
                @include('components.paginate', ['records' => $course_resources])
            </div>

        </div>
    </div>

@endsection

