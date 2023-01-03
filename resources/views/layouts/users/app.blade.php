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
  <link href="{{asset('/')}}assets/user_fronts/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('/')}}assets/user_fronts/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{asset('/')}}assets/user_fronts/css/style.css" rel="stylesheet">

   <!-- Bootstrap CSS -->
   {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> --}}
   <link href="{{asset('/')}}assets/user_fronts/css/toggle_list.css" rel="stylesheet">
   <link href="{{asset('/')}}assets/user_fronts/css/custom.css" rel="stylesheet">
  <!-- Toastr CDN --->
  <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  @yield('style')
</head>

<body class="p-4">
<!--header -->
    @include('layouts.users.header_nav')
  <main id="main">
    <div class="content-page pt-3" style="min-height:760px;">
        @yield('content')
    </div>
    <!--Footer to start -->
      @include('layouts.users.footer_top')
    <!--Footer to End -->
      <!-- Footer Start -->
      @include('layouts.users.footer')
      <!-- end Footer -->
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @yield('modal')

  <!-- Vendor JS Files -->
  <script>

    </script>
  <script src="{{asset('/')}}assets/user_fronts/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/js/toggle_list.js"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('/')}}assets/user_fronts/js/main.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/js/filter.js"></script>
  <script src="{{asset('/')}}assets/user_fronts/js/custom.js"></script>

  

  <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! \Brian2694\Toastr\Facades\Toastr::message() !!}

  @stack('script')

</body>

</html>
