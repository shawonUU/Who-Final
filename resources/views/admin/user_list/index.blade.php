@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col col-sm-6">
                    <h1>{{__(request()->query('type').' Trainees List')}}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="form-contents-table mb-2">
        @include('admin.user_list.elements.filters')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                @include('admin.user_list.table')
                @include('components.paginate', ['records' => $users])
            </div>
        </div>
    </div>

@endsection

