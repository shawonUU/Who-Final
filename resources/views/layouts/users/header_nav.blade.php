<!-- ======= Header ======= -->
<div class="container d-flex align-items-center justify-content-between" style=" background-color:#ffffff">
  <a href="{{url('/')}}" class="logo"><img src="{{asset('/')}}assets/user_fronts/img/logo/gront_logo.jpeg" alt="Logo" class="img-fluid" ></a>
  <a href="{{url('/')}}" class="logo px-5"><img src="{{asset('/')}}assets/user_fronts/img/logo/bd_logo.png" alt="Logo" class="img-fluid" ></a>
  <a href="{{url('/')}}" class="logo pr-2"> <img src="{{ asset('/') }}assets/user_fronts/img/app/header/Image20221213094834.jpg"
    class="img-fluid" alt="who-logo " style="width:300px;"></a>
</div>
<header id="header" class="mb-0" style="background-color: #108EC7">
    <div class="container d-flex align-items-center">

      {{-- <h1 class="logo me-auto"><a href="#">SAM Online</a></h1> --}}
      <!-- Uncomment below if you prefer to use an image logo -->
       {{-- <a href="{{url('/')}}" class="logo"><img src="{{asset('/')}}assets/user_fronts/img/logo/bd_logo.png" alt="Logo" class="img-fluid" ></a>
       <a href="{{url('/')}}" class="logo me-auto"><img src="{{asset('/')}}assets/user_fronts/img/logo/gront_logo.jpeg" alt="Logo" class="img-fluid" ></a> --}}

      <nav id="navbar" class="navbar" style="margin:auto" >
        <ul>
          <li><a class="nav-link scrollto {{ request()->route()->getName() == 'user.index'  ? 'active' : '' }}" href="{{url('/')}}">{{ __('frontend_Home') }}</a></li>
          <li><a class="nav-link scrollto {{ request()->route()->getName() == 'user.course.cources'  ? 'active' : '' }}" href="{{route('user.course.cources')}}">{{ __('frontend_Course') }}</a></li>
          @if(!Auth::guard('admin')->check())
          <li><a class="nav-link scrollto {{ request()->route()->getName() == 'user.course.my_cources'  ? 'active' : '' }}" href="{{route('user.course.my_cources')}}">{{ __('frontend_My Course') }}</a></li>
          @endif
          <li class="dropdown"><a href="#"><span>{{ __('Resource') }}</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <li><a href="">{{ __('FAQ') }}</a></li>
            <li><a href="">{{ __('User Guide') }}</a></li>
            <li><a href="">{{ __('Training Manual') }}</a></li>
            </ul>
        </li>
    
            
          @if (Auth::check() || Auth::guard('admin')->check())

          <li class="dropdown"><a href="#"><span>{{Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name }}</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              @auth('admin')
               <li><a href="{{route('admin.profile')}}">{{ __('frontend_Profile') }}</a></li>
               <li><a href="{{ route('admin.logoutAdmin') }}">{{ __('frontend_Logout') }}</a></li>
              @endauth
              @auth('web')
               <li><a href="{{route('user.profile')}}">{{ __('frontend_Profile') }}</a></li>
               <li><a href="{{ route('user.logout') }}">{{ __('frontend_Logout') }}</a></li>
              @endauth
               
            </ul>
        </li>

          @else
            <li><a class="getstarted scrollto" href="{{ route('login') }}">{{ __('frontend_Login') }}</a></li>
            <li><a class="getstarted scrollto" href="{{ route('user.register.page') }}">{{ __('frontend_Registered') }}</a></li>
          @endif
          <li class="dropdown">
            @if(session('APP_LOCALE') === 'en')
            <a class="nav-link mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('assets')}}/images/flags/us.jpg" alt="user-image" class="mr-2" height="12"> <span class="align-middle">English <i class="bi bi-chevron-down"></i> </span>
            </a>
            @else
                <a class="nav-link  mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('assets')}}/images/flags/bangladesh.png" alt="user-image" class="mr-2" height="12"> <span class="align-middle">বাংলা <i class="bi bi-chevron-down"></i> </span>
                </a>
            @endif
            <ul>
            <li>
               <!-- item-->
               <a href="{{route('change.locale','bn')}}" class="dropdown-item notify-item">
                <img src="{{asset('assets')}}/images/flags/bangladesh.png" alt="user-image" class="" height="12"> <span class="">বাংলা</span>
               </a>
            </li>
            <li>
               <!-- item-->
               <a href="{{route('change.locale','en')}}" class="dropdown-item notify-item">
                <img src="{{asset('assets')}}/images/flags/us.jpg" alt="user-image" class="" height="12"> <span class="">English</span>
               </a>
            </li>
            </ul>
        </li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
    <h3 class="text-white text-center py-5" style="margin-bottom: -50px">{{ __('heading') }}</h3>
  </header><!-- End Header -->
