<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SamOnlineUsersPDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SAM - Online" name="description" />
    <meta content="Riseup Labs" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="">

    <div class="content-page">
       <h2 class="text-center">{{ $content_name }}</h2>
        <div class="table-responsive">
            <table class="table table-striped" id="admins-table">
                <thead>
                    <tr>
                        <th>{{ __('SL') }}</th>
                        <th>{{ __('Full Name') }}</th>
                         <th>{{ __('Phone') }}</th>
                        <th>{{ __('Date of Registration') }}</th>
                        <th>{{ __('Last active Date') }}</th>
                        <th>{{ __('Gaps( Days )') }}</th>
                        {{-- <th>{{ __('Details') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                @foreach($users ?? [] as $key=>$user)
                    <tr>
                        <th>{{$key+1}}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->last_login_at }}</td>
                        <td>{{ Carbon\Carbon::parse($user->last_login_at)->diffInDays(Carbon\Carbon::now()) }} Days</td>         
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>


