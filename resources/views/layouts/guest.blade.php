<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo/smart-favicon.png') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="{{asset('dashboard/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('dashboard/assets/css/bootstrap-extended.css')}}" rel="stylesheet" />
    <link href="{{asset('dashboard/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('dashboard/assets/css/icons.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="{{asset('dashboard/assets/css/pace.min.css')}}" rel="stylesheet" />

    <title>Stay Smart Apartments | Dashboard</title>
</head>

<body class="bg-login">

    <!--start wrapper-->
    <div class="wrapper">

        @yield('content')

    </div>
    <!--end wrapper-->

    <!--plugins-->
    <script src="{{asset('dashboard/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/pace.min.js')}}"></script>
</body>

</html>