<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="e-learning platform by CBHC" name="description" />
    <meta content="Riseup Labs" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/')}}assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="{{asset('/')}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{asset('/')}}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{asset('/')}}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <!-- Toastr CDN --->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!--Custom Style Area -->
    <style>
    .item-photo__preview {
        width: 150px;
        height: 150px;
    }
    </style>

    @yield('style')

</head>

<body class="left-side-menu-light sidebar-enable">


<!-- Begin page -->
<div id="wrapper">


    <!-- Topbar Start -->
    @include('layouts.header')
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    @include('layouts.sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

        @yield('content')

        <!-- Footer Start -->
        @include('layouts.footer')
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->



@yield('modal')

<!-- Vendor js -->
<script src="{{asset('/')}}assets/js/vendor.min.js"></script>

<script src="{{asset('/')}}assets/libs/moment/moment.min.js"></script>
<script src="{{asset('/')}}assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="{{asset('/')}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- init JS -->
<script src="{{asset('/')}}assets/js/pages/dashboard.init.js"></script>
<script src="{{asset('/')}}assets/libs/jquery-steps/jquery.steps.min.js"></script>
<script src="{{asset('/')}}assets/js/pages/form-wizard.init.js"></script>
<script src="{{asset('/')}}assets/libs/jquery-validation/jquery.validate.min.js"></script>
<!-- Modal-Effect -->
<script src="{{asset('/')}}assets/libs/custombox/custombox.min.js"></script>

<!-- App js -->
<script src="{{asset('/')}}assets/js/app.min.js"></script>

<!-- NB: Custom JS Section -->
<!--Filter Class -->
<script src="{{asset('/')}}assets/js/filter.js"></script>
<!--Image Preview -->
<script src="{{asset('/')}}assets/js/image_preview.js"></script>

<!-- NB: Custom JS Section END -->


<!-- Chat app -->
<script src="{{asset('/')}}assets/js/pages/jquery.chat.js"></script>

<!-- Todo app -->
<script src="{{asset('/')}}assets/js/pages/jquery.todo.js"></script>

<!-- flot chart -->
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.time.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.resize.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.pie.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.selection.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.stack.js"></script>
<script src="{{asset('/')}}assets/libs/flot-charts/jquery.flot.crosshair.js"></script>



<!-- Dashboard init JS -->
<script src="{{asset('/')}}assets/js/pages/dashboard.init.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<!-- Toastr CDN --->
{{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! \Brian2694\Toastr\Facades\Toastr::message() !!}

<script>
    $(document).ready(function() {
    //    $('#summernote').summernote();
    $(".summernote").summernote({
        height: 300,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });
    });
</script>

@stack('script')



</body>

</html>
