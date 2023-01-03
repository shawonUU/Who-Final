@extends('layouts.app')
@section('title')
    {{__('Dashboard')}}
@endsection
@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title"> {{__('Welcome To Admin Dashboard')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb p-0 m-0">
                                <li class="breadcrumb-item"><a href="#">SAM</a></li>
                                <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
                            </ol>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            @include('dashboard.admin.elements.filters')

            <!--Widget-4 -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-info rounded-circle mr-2">
                                <i class="ion ion-md-person-add avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_registered_user'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Registered Users')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->
                </div>


                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-success rounded-circle">
                                <i class="fa fas fa-user-graduate avatar-title font-26 text-white"></i> 
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_completed'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Course Completed')}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-primary rounded-circle">
                                <i class="mdi mdi-file-certificate avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_certificate_download'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Download Certificates')}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-info rounded-circle">
                                <i class="mdi mdi-biathlon avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_active_user'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Active Users')}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end card-box-->
                </div>


                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-purple rounded-circle">
                                <i class="ion-md-man avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_inactive_user'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Inactive Users')}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end card-box-->
                </div>



                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-primary rounded-circle">
                                <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="">{{ $data['total_hybernate_user'] }}</span></h4>
                                    <p class="mb-0 mt-1 text-truncate">{{__('Total Hibernate Users')}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end card-box-->
                </div>

            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-4">
                    @include('dashboard.admin.elements.user_status_pie_chart')
                </div>
            </div>

            
               
              



        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end content -->
@endsection

