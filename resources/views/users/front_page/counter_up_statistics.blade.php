
<div class="card mt-1">
    <div class="row">
      <div class="col-md-4 counter_parent" >
        <h1><span class="counter">5</span></h1>
        <h3>{{ __('frontend_Registered') }}</h3>
        <i class="fa fa-users"></i>
      </div> 
      <div class="col-md-4 counter_parent">
        <h1><span class="counter">3</span></h1>
        <h3>{{ __('frontend_Completed the Course') }}</h3>
        <i class="fa fa-desktop"></i>
      </div>
      <div class="col-md-4 counter_parent">
        <h1><span class="counter">10</span></h1>
        <h3>{{ __('frontend_Number of visitors') }}</h3>
        <i class="fa fa-coffee"></i>
      </div>
    </div>
</div>

  @push('script')
  <script>
    $('.counter').counterUp({
        delay: 10,
        time: 2000
    });
    $('.counter').addClass('animated fadeInDownBig');
    $('h3').addClass('animated fadeIn');
  </script>
  @endpush