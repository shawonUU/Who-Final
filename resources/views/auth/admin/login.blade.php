@extends('layouts.app_login')
@section('content')
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-header bg-img p-5 position-relative">
                            <div class="bg-overlay"></div>
                            <h4 class="text-white text-center mb-0">Sign In to WHO eLearning</h4>
                        </div>
                        <div class="card-body p-4 mt-2">
                            <form action="{{route('admin.login')}}" class="p-3" method="post">@csrf

                                <div class="form-group mb-3">
                                    <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                </div>

                                <div class="form-group mb-3">
                                    <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                </div>

                                <div class="form-group text-center mt-5 mb-4">
                                    <button class="btn btn-primary waves-effect width-md waves-light" type="submit"> Log In </button>
                                </div>

{{--                                <div class="form-group row mb-0">--}}
{{--                                    <div class="col-sm-7">--}}
{{--                                        <a href="pages-recoverpw.html"><i class="fa fa-lock mr-1"></i> Forgot your password?</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-5 text-right">--}}
{{--                                        <a href="pages-register.html">Create an account</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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
