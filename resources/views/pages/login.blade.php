<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="{{{ URL::asset('template/css/font-face.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/font-awesome-4.7/css/font-awesome.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/font-awesome-5/css/fontawesome-all.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/mdi-font/css/material-design-iconic-font.min.css')}}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{{ URL::asset('template/vendor/bootstrap-4.1/bootstrap.min.css')}}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{{ URL::asset('template/vendor/animsition/animsition.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/wow/animate.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/css-hamburgers/hamburgers.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/slick/slick.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/select2/select2.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/perfect-scrollbar/perfect-scrollbar.css')}}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{{ URL::asset('template/css/theme.css')}}}" rel="stylesheet" media="all">

    <style>
        .login-content{
            border-radius: 10px;
        }
    </style>
</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="{{{URL::asset('template/images/icon/algostudio_logo.png')}}}" width="60" height="auto" alt="Cool Admin" />
                                <h3>
                                    LOGIN 
                                </h3>
                            </a>
                        </div>
                        <div class="login-form">
                            @if(session('errors'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Something it's wrong:
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" type="username" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{{ URL::asset('template/vendor/jquery-3.2.1.min.js')}}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{{ URL::asset('template/vendor/bootstrap-4.1/popper.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/bootstrap-4.1/bootstrap.min.js')}}}"></script>
    <!-- Vendor JS       -->
    <script src="{{{ URL::asset('template/vendor/slick/slick.min.js')}}}">
    </script>
    <script src="{{{ URL::asset('template/vendor/wow/wow.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/animsition/animsition.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}}">
    </script>
    <script src="{{{ URL::asset('template/vendor/counter-up/jquery.waypoints.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/counter-up/jquery.counterup.min.js')}}}">
    </script>
    <script src="{{{ URL::asset('template/vendor/circle-progress/circle-progress.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/perfect-scrollbar/perfect-scrollbar.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/chartjs/Chart.bundle.min.js')}}}"></script>
    <script src="{{{ URL::asset('template/vendor/select2/select2.min.js')}}}">
    </script>

    <!-- Main JS-->
    <script src="{{{ URL::asset('template/js/main.js')}}}"></script>

</body>

</html>
<!-- end document-->