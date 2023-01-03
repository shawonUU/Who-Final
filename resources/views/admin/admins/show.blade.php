@extends('layouts.app')
@section('title')
    {{__('Admin Details')}}
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left pt-2"> {{__('Profile')}}</h2>
                </div>
                <div class="card-body">

                    <div class="row">

                        <!-- Profile Image -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        {{-- <div class="col-md-12 text-center ">
                                            <img id="currentPhoto" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="Profile Image" style="max-height: 150px;border-radius: 10px;">
                                        </div> --}}

                                        <div class="col-md-12">
                                            <br>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Joined at')}}</th>
                                                    <td>
                                                        {{date('d M, Y', strtotime($admin->created_at))}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Status')}}</th>
                                                    <td>
                                                        @if($admin->status == 'active')
                                                            <span class="badge badge-success">{{__('Active')}}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{__('Inactive')}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Email')}}</th>
                                                    <td>
                                                        {{$admin->email}}
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <th>{{__('Phone')}}</th>
                                                    <td>
                                                        {{$admin->phone}}
                                                    </td>
                                                </tr> --}}
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Details -->
                        <div class="col-md-7">
                            <div class="card">
                                <!--Show Validation error message !-->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                <div class="card-body">
                                    <form action="{{route('admin.update',$admin->id)}}" enctype="multipart/form-data" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="row">
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label> {{__('Name')}}</label>
                                                <input value="{{$admin->name}}"  type="text" name="name" class="form-control">
                                                <input value="{{$admin->id}}" type="hidden" name="id">
                                                <input value="{{$admin->type}}" type="hidden" name="type">
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label> {{__('Email')}}</label>
                                                <input value="{{$admin->email}}"  type="email" name="email" class="form-control">
                                            </div>
                                            {{-- <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label> {{__('Phone')}}</label>
                                                <input value="{{$admin->phone}}"  type="number" name="phone" class="form-control">
                                            </div> --}}
                                                <div class=" form-group col-md-12 col-sm-12 col-12 text-left">
                                                    <span class="ml-4"> <input class="form-check-input checkbox" value="cps" type="checkbox"  name="change_pass" id="changePass"> {{__('Change Password')}}</span>
                                                </div>
                                                <div id="showPass" style="display: none;width: 100%">
                                                    <div class=" form-group col-md-12 col-sm-12 col-12">
                                                        <label>{{__('New Password')}}</label>
                                                        <input placeholder="{{__('Password')}}"  type="password" name="password" class="form-control">
                                                    </div>
                                                    <div class=" form-group col-md-12 col-sm-12 col-12">
                                                        <label>{{__('Confirm Password')}}</label>
                                                        <input placeholder="Confirm Password"  type="password" name="confirm_password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class=" form-group col-md-12 col-sm-12 col-12">
                                                    <button class="btn btn-primary btn-block" type="submit" >{{__('Save Changes')}}</button>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('script')
    @include('admin.profile.script')
@endpush

