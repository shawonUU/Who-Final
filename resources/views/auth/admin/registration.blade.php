@extends('layouts.app_login')
@section('title')
    {{__('Register Admin')}}
@endsection
@section('content')
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-header bg-img p-5 position-relative">
                            <div class="bg-overlay"></div>
                            <h4 class="text-white text-center mb-0">{{__('Register Admin')}}</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            @if($errors->any())
                               @foreach ($errors->all() as $error)
                                  <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                            <form action="{{route('admin.create')}}" class="p-3" method="post" enctype="multipart/form-data">@csrf

                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" name="name"  placeholder="{{__('Name')}}">
                                </div>

                                <div class="form-group mb-3">
                                    <input class="form-control" type="email" name="email" required="" placeholder="{{__('Email')}}">
                                </div>

                                <div class="form-group mb-3">
                                    <input class="form-control" type="number" name="phone" required="" placeholder="{{__('Phone')}}">
                                </div>


                                <div class="form-group mb-3">
                                    <input class="form-control" type="password" name="password" required="" placeholder="{{__('Password')}}">
                                </div>

                                {{-- <div class="form-group mb-3">
                                    <input class="form-control" type="file" name="avatar">
                                </div> --}}

                                <div class="form-group text-center mt-5 mb-4">
                                    <button class="btn btn-primary waves-effect width-md waves-light" type="submit"> {{__('Register')}} </button>
                                </div>
                            </form>

                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
    </div>
@endsection
