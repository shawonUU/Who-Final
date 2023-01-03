@extends('layouts.app')
<?php $auth = Auth::guard('admin')->user() ?>
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h1>{{__(request()->query('type').' List')}}</h1>
                </div>
                @if( $auth->type == 'admin')  <!--Change it when admin has role column -->
                <div class="col col-sm-6 mt-1">
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#adminCreateModal">
                        {{__('Add New')}}
                    </button>
                    {{-- <a class="btn btn-primary float-right"
                       href="{{ route('admin.admins.create',['type'=>request()->query('type')]) }}">
                        {{__('Add New')}}
                    </a> --}}
                </div>
                @endif
            </div>
        </div>
    </section>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-contents-table">
        @include('admin.admins.elements.filters')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                @include('admin.admins.table')
                @include('components.paginate', ['records' => $admins])
            </div>
        </div>
    </div>

@endsection

@section('modal')

    <div class="modal fade" id="adminCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{route('admin.admins.store')}}" method="post" enctype="multipart/form-data">@csrf
                <div class="modal-content">
                    <div class="modal-header bg-img text-center">
                        <h4 class= "text-center text-white">{{ __('Add '.request()->query('type')) }}
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input class="form-control" type="text" name="name" required=""  placeholder="{{__('Name')}}">
                        </div>

                        <div class="form-group mb-3">
                            <input class="form-control" type="email" name="email" required="" placeholder="{{__('Email')}}">
                        </div>

                        {{-- <div class="form-group mb-3">
                            <input class="form-control" type="number" name="phone" required="" placeholder="{{__('Phone')}}">
                        </div> --}}


                        <div class="form-group mb-3">
                            <input class="form-control" type="password" name="password" required="" placeholder="{{__('Password')}}">
                        </div>

                        {{-- <div class="form-group mb-3">
                            <input class="form-control" type="file" name="avatar">
                        </div> --}}
                        <input type="hidden" name="type" value="{{ request()->query('type') }}"/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection



