<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="e-learning platform by CBHC" name="description" />
    <meta content="Riseup Labs" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- Favicons -->
  <link href="{{asset('/')}}assets/user_fronts/img/book.png" rel="icon">
  <link href="{{asset('/')}}assets/user_fronts/img/book.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Vendor CSS Files -->
  {{-- <link href="{{asset('/')}}assets/user_fronts/vendor/aos/aos.css" rel="stylesheet"> --}}
  <link href="{{asset('/')}}assets/user_fronts/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('/')}}assets/user_fronts/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  {{-- <link href="{{asset('/')}}assets/user_fronts/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> --}}
  {{-- <link href="{{asset('/')}}assets/user_fronts/vendor/glightbox/css/glightbox.min.css" rel="stylesheet"> --}}
  {{-- <link href="{{asset('/')}}assets/user_fronts/vendor/remixicon/remixicon.css" rel="stylesheet"> --}}
  {{-- <link href="{{asset('/')}}assets/user_fronts/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> --}}

  <!-- Template Main CSS File -->
  <link href="{{asset('/')}}assets/user_fronts/css/style.css" rel="stylesheet">

   <!-- Bootstrap CSS -->
   {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> --}}
   <link href="{{asset('/')}}assets/user_fronts/css/toggle_list.css" rel="stylesheet">

  <!-- Toastr CDN --->
  <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

<style>
  p{
    font-weight:bold;
    font-size: 14px;
  }
  </style>

      <style>
      .counter_parent {
    text-align: center;
    padding-bottom: 50px;
    border-right: 1px dashed black;
  }

  .counter_parent:last-child {
    border-right: 0px solid black;
  }

  .counter {
    animation-duration: 1s;
    animation-delay: 0s;
  }

  i {
    font-size: 20px !Important;
  }

  @media (max-width: 991px) {
    .counter_parent {
      border-right: 0px dashed black;
      border-bottom: 1px dashed black;
      width: 50%;
      margin: auto auto;
    }

    .counter_parent:last-child {
      border-bottom: 0px dashed black;
    }
  }

  .jumbotron {
  background-repeat: no-repeat;
  background-image: url('{{asset('/')}}assets/user_fronts/img/app/Group-6273.png');
  background-size: cover;
  background-position:center;
  /* position: relative;
  overflow: hidden; */
}

.jumbotron2 {
  background-repeat: no-repeat;
  background-image: url('{{asset('/')}}assets/user_fronts/img/app/Group-6274.png');
  background-size: cover;
  background-position:right;
  /* position: relative;
  overflow: hidden; */
}
/* .jumbotron >img {
position: absolute;
bottom: 0;
width: 150%;
left: 0;
right: 0;
z-index: 1;
} */

.field-icon {
  float: right;
  margin-right: 10px;
  margin-top: -30px;
  position: relative;
  z-index: 2;
}
</style>

<style>
  /* profile image */

  .avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
</style>

  <!-- =======================================================
  * Template Name: Arsha - v4.9.0
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  @yield('style')
</head>

<body>

<!--header -->
    @include('layouts.users.header_nav')

  <main id="main">
    <div class="content-page">

        @yield('content')

    </div>

    <!--Footer to start -->
      {{-- @include('layouts.users.footer_top') --}}
    <!--Footer to End -->

      <!-- Footer Start -->
      @include('layouts.footer')
      <!-- end Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @yield('modal')

  <!-- Vendor JS Files -->
  {{-- <script src="{{asset('/')}}assets/user_fronts/vendor/aos/aos.js"></script> --}}
  <script src="{{asset('/')}}assets/user_fronts/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  {{-- <script src="{{asset('/')}}assets/user_fronts/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/vendor/waypoints/noframework.waypoints.js"></script> --}}
  {{-- <script src="{{asset('/')}}assets/user_fronts/vendor/php-email-form/validate.js"></script> --}}
  <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/js/toggle_list.js"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('/')}}assets/user_fronts/js/main.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/js/filter.js"></script>

  <script type="text/javascript">
    $(".toggle-password").click(function() {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    });

    $(".toggle-confirm-password").click(function() {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    });


    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        $("#avatar-btn").css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
    </script>

  <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! \Brian2694\Toastr\Facades\Toastr::message() !!}

  @stack('script')

</body>

</html>
