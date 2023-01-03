@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h4>{{__('Course Modules')}}</h4>
                </div>
                <div class="col col-sm-6 mt-2">
                    <button type="button" class="btn btn-info btn-sm ml-1 float-right" data-toggle="modal" data-target="#courseModuleCreateModal">
                        {{__('Add Module')}}
                    </button>
                    {{-- <a href="{{ route('admin.course_module.create',['course_id'=>1]) }}" class="btn btn-info btn-sm ml-1 float-right">{{  __('Add Module') }}</a> --}}
                </div>
            </div>
        </div>
        @include('admin.course_module.elements.module_create_modal')
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
        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.course_module.table')
                {{-- @include('components.paginate', ['records' => $course_modules]) --}}
            </div>

        </div>
    </div>

@endsection

