<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        {{-- <li class="dropdown d-none d-lg-block">
            @if (session('APP_LOCALE') === 'en')
            <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('assets')}}/images/flags/us.jpg" alt="user-image" class="mr-2" height="12"> <span class="align-middle">English <i class="mdi mdi-chevron-down"></i> </span>
            </a>
            @else
                <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('assets')}}/images/flags/bangladesh.png" alt="user-image" class="mr-2" height="12"> <span class="align-middle">বাংলা <i class="mdi mdi-chevron-down"></i> </span>
                </a>
            @endif
            <div class="dropdown-menu dropdown-menu-right">
                <!-- item-->
                <a href="{{route('change.locale','bn')}}" class="dropdown-item notify-item">
                    <img src="{{asset('assets')}}/images/flags/bangladesh.png" alt="user-image" class="mr-2" height="12"> <span class="align-middle">বাংলা</span>
                </a>

                <!-- item-->
                <a href="{{route('change.locale','en')}}" class="dropdown-item notify-item">
                    <img src="{{asset('assets')}}/images/flags/us.jpg" alt="user-image" class="mr-2" height="12"> <span class="align-middle">English</span>
                </a>

            </div>
        </li> --}}


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="user-image"
                    class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                <!-- item-->
                <a href="{{ route('admin.profile') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-face-profile"></i>
                    <span>{{ __('Profile') }}</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                @auth('web')
                    <a href="{{ route('user.logout') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-power-settings"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                @endauth
                @auth('admin')
                    <a href="{{ route('admin.logoutAdmin') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-power-settings"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                @endauth

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                {{-- <img src="{{ asset('/') }}assets/images/logo-dark.png" alt="" height="25"
                    style="padding-right: 10px;"> --}}
                <span class="logo-lg-text-light">CBHC eLearning</span>
            </span>
            {{-- <span class="logo-sm">
                                <span class="logo-lg-text-light"></span>
                               <img src="{{asset('/')}}assets/images/logo-admin.png" alt="" height="25">
                            </span> --}}
        </a>

        <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-light">
            <span class="logo-lg">
                {{-- <img src="{{ asset('/') }}assets/images/logo-admin.png" alt="" height="25"
                    style="padding-right: 10px;"> --}}
                <span class="logo-lg-text-light">CBHC eLearning</span>
            </span>
            {{-- <span class="logo-sm">
                                <span class="logo-lg-text-light"></span>
                               <img src="{{asset('/')}}assets/images/logo-admin.png" alt="" height="25">
                            </span> --}}
        </a>
    </div>

    <!-- LOGO -->


    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>

        <li class="d-none d-sm-block">
            {{--            <form class="app-search"> --}}
            {{--                <div class="app-search-box"> --}}
            {{--                    <div class="input-group"> --}}
            {{--                        <input type="text" class="form-control" placeholder="Search..."> --}}
            {{--                        <div class="input-group-append"> --}}
            {{--                            <button class="btn" type="submit"> --}}
            {{--                                <i class="fas fa-search"></i> --}}
            {{--                            </button> --}}
            {{--                        </div> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </form> --}}
        </li>
    </ul>
</div>
