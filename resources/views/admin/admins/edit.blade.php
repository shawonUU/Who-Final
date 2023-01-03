@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Admin</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content-page-edit">

        <div class="card">

            {!! Form::model($admin, ['route' => ['admin.admins.update', $admin->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.admins.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.admins.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
