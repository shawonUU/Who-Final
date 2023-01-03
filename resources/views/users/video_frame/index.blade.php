@extends('layouts.users.app')
@section('style')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <style>
        #video-menu {
            display: none;
        }

        #video-menu>ul {
            list-style-type: none;
            display: block;
            line-height: 2;
            /* font-family: 'Russo One', sans-serif; */
            background-color: #837AD3;
            text-align: center;
            padding: 20px;
            margin-top: 0;
            width: 25%;
            font-size: 80%;
            border-radius: 10px;
            z-index: 1;
            margin-top: 0px;
            float: left;
        }

        #video_toggle_menue {
            cursor: pointer;
            border: none;
            padding: 10px;
            border-radius: 10px;
            background-color: #6c5df5;
            color: #13085E;
            font-size: 100%;
            font-weight: bold;
            float: left;
            margin-top: 10px;
            margin-right: 10px;
        }

        #video-menu>ul>li>a {
            text-decoration: none;
            color: #13085E;
        }

        #video-menu>ul>li>a:hover {
            color: pink;
        }
    </style>


    <style>
        .fill-in-the-gaps {
            outline: 0;
            border-width: 0 0 2px;
            border-color: #797979;
        }

        .fill-in-the-gaps:focus {
            border-color: green
        }
    </style>

    <style>
        audio::-webkit-media-controls-timeline,
        video::-webkit-media-controls-timeline {
            display: none;
        }
        .cui-toolbar-buttondock {
            display: none;
        }
    </style>
@endsection

@section('content')
    <!-- Video hedear -->
    {{-- @include('users.video_frame.video_header')
    <div class="clearfix"></div> --}}
    <div class="row">
        <div class="col-md-7">
            <!-- Video Body -->
            @include('users.video_frame.video_body')

            <div class="clearfix"></div>

            <!--Video Footer -->
            @include('users.video_frame.video_footer')
        </div>
        <div class="col-md-5">
            @include('users.video_frame.content_list')
        </div>
    </div>
@endsection

@push('script')
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#video_toggle_menue").click(function() {
                $("#video-menu").slideToggle("slow");
            });
        });

        $("#myVideo").bind("click", function() {
            var vid = $(this).get(0);
            if (vid.paused) {
                vid.play();
            } else {
                vid.pause();
            }
        });

        var video = document.getElementById("myVideo");
        var button = document.getElementById("nextButton")

        if (video) {
            if (button) {
                document.getElementById('myVideo').addEventListener('ended', videoEndHandler, false);

                function videoEndHandler(e) {
                    $(".module_complete_status").css({
                        "display": "block"
                    });
                    document.getElementById("nextButton").classList.remove("disabled");
                }
            } else {
                document.getElementById('myVideo').addEventListener('ended', videoEndHandler, false);

                function videoEndHandler(e) {
                    $(".module_complete_status").css({
                        "display": "block"
                    });
                    document.getElementById("takeQuiz").classList.remove("disabled");
                }
            }


        } else {
            window.onload = function() {

                var content = $('.module_complete_status');
                var timer = content.attr('timer')*60*1000;
                console.log(timer);

                setTimeout(function() {
                    $(".module_complete_status").css({
                        "display": "block"
                    });
                    document.getElementById("nextButton").classList.remove("disabled");
                }, timer);
            }
        }

        var content = $('.module_complete_status');
        var timeleft = content.attr('timer')*60;
        var downloadTimer = setInterval(function(){
        if(timeleft <= 3){
            clearInterval(downloadTimer);
             $("#countdown").css("display", "none");
        } else {
            document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
        }
        timeleft -= 1;
        }, 1000);
    </script>

    <script>
        $(document).ready(function() {

            $(".module_complete_status").click(function() {

                var content = $('.module_complete_status'),
                    current_sub_module_id = content.attr('current-sub-module-id');
                content_type = content.attr('next-content-type');
                next_sub_module_id = content.attr('next-content-id');
                // console.log(current_sub_module_id);
                // console.log(content_type);
                // console.log(next_sub_module_id);
                // return;

                var url = "{{ route('unlock_next_content') }}";
                // url = url.replace('module_id_temp', current_module_id);

                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        current_sub_module_id: current_sub_module_id,
                        content_type: content_type,
                        next_sub_module_id: next_sub_module_id,
                    },

                    success: function(data) {
                        console.log(data);
                        if (data.status === 'success') {
                            successMessage(data.message);
                            $('.video-footer').load(url);
                            // $('.video-footer').load(location.href + ' .video-footer');
                            location.reload();
                        } else {
                            $.each(data.errors, function(key, value) {
                                errorMessage(value);
                            })
                            $('.video-footer').load(location.href + ' .video-footer');
                            location.reload();
                        }
                    },
                    error: function(data) {
                        errorMessage('Something Went wrong!');
                        $('.video-footer').load(location.href + ' .video-footer');
                        location.reload();
                    }
                });
            });
        });


        function successMessage(message) {
            Command: toastr["success"](message)

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "100",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }

        function errorMessage(message) {
            Command: toastr["error"](message)

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }
    </script>
@endpush
