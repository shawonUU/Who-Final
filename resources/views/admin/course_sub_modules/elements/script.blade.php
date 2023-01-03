<script>
    $(document).ready(function(){
        // $('#showPassRow').hide();
        $('#changePass').on('click',function (){
            $('#showPass').toggle(1000);
        });

    });
</script>

@error('password')
<script>
    $(document).ready(function(){
        $('#showPass').show();
        $('input[type=checkbox]').prop('checked',true);
    });
</script>
@enderror

@error('confirm_password')
<script>
    $(document).ready(function(){
        $('#showPass').show();
    });
</script>
@enderror

<!-- Validation Errorr Message -->
@if($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Command: toastr["error"]("{{$error}}")

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
        </script>
    @endforeach
@endif


@if (Session::has('attemptSuccess'))
    <script>
        Command: toastr["success"]("{{Session::get('attemptSuccess')}}")

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

    </script>
@endif

@if (Session::has('attemptFail'))
    <script>
        Command: toastr["error"]("{{Session::get('attemptFail')}}")

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

    </script>
@endif
