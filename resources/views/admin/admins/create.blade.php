@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create {{ request()->query('type') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

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

        <div class="card">

            {!! Form::open(['route' => 'admin.admins.store']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.admins.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.list',['type'=> request()->query('type')] ) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
