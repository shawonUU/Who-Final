@extends('layouts.users.app')
@section('style')
<style>
    .carousel-caption {
    top: 20%;
    text-align: left;
}
/* .carousel-item {
  	transition: -webkit-transform 0.3s ease;
  	transition: transform 0.3s ease;
  	transition: transform 0.3s ease, -webkit-transform 0.3s ease;
  	-webkit-backface-visibility: visible;
  	backface-visibility: visible;
} */

@media only screen and (min-width: 360px) and (max-width: 768px) {
	.carousel-caption {
    top:  11%;
    }
  .carousel-caption> h1{
     font-size: 14px;
  }

  
}

@media only screen and (min-width: 769) and (max-width: 991px) {
	.carousel-caption {
    bottom:  30.25rem;
    font-size: ; 
  }
}


</style>
@endsection

@section('content')


 
@include('users.front_page.counter_up_statistics')
@include('users.front_page.introduction')
  @include('users.front_page.about_course')
{{-- @include('users.front_page.learning_objectives') --}}
{{-- @include('users.front_page.module_toggle') --}}
@include('users.front_page.slider')


@endsection

@push('script')

<script>

$('.carousel').carousel({
  interval: 5000,
  pause: "false"
});
</script>

@endpush


