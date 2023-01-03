<footer class="footer" style="background-color: #fff; max-height:180px; font-size:18px; mt-2">
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 text-white pt-2" style="font-size: 14px;">   
                    <img src="{{ asset('/') }}assets/user_fronts/img/app/footer/who-co-bangladesh-white.webp"
                    class="img-fluid float-end" alt="stunning-trend-in-bd" style="max-height: 75%">
            </div>
            <div class="col-sm-2 text-white text-start" style="font-size: 14px;">                                   
                <span class="float-start pt-5"  >&copy; 2022 WHO</span>    
            </div>
            <div class="col-sm-7 container d-flex align-items-center my-1" style=" background-color:#ffffff">
                <a href="{{url('/')}}" class="logo"><img src="{{asset('/')}}assets/user_fronts/img/logo/bd_logo.png" alt="Logo" class="img-fluid" ></a>
                 <a href="{{url('/')}}" class="logo me-auto"><img src="{{asset('/')}}assets/user_fronts/img/logo/gront_logo.jpeg" alt="Logo" class="img-fluid" ></a>
              </div>

        </div>
    </div> --}}

    <div class="container d-flex align-items-center justify-content-between" style=" background-color:#ffffff">
           
            <a href="{{url('/')}}" class="logo"><img src="{{asset('/')}}assets/user_fronts/img/logo/gront_logo.jpeg" alt="Logo" class="img-fluid" ></a>        
            <a href="{{url('/')}}" class="logo px-5"><img src="{{asset('/')}}assets/user_fronts/img/logo/bd_logo.png" alt="Logo" class="img-fluid" ></a>
            <div class="col-4 mt-2 text-center">
                <h6>{{ __('Developed in partnership with') }}</h6>
                <a href="{{url('/')}}" class="logo pl-2"> <img src="{{ asset('/') }}assets/user_fronts/img/app/header/Image20221213094834.jpg"
                    class="img-fluid" alt="who-logo " style="width:280px;"></a>
                <p class="float-center"  >&copy; {{ __('2022 WHO') }}</p>                
            </div>
            <a href="https://riseuplabs.com/" class="riseuplabs" target="_blank"><img src="{{asset('/')}}assets/user_fronts/img/app/footer/Design & Developed By Riseup Labs.jpg" alt="Logo" class="img-fluid"  style="width:450px"></a>
           
      
      </div>
</footer>