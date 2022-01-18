<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>@yield('title')</title>

   <!-- Fontfaces CSS-->
    <link href="{{{ URL::asset('template/css/font-face.css') }}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/font-awesome-4.7/css/font-awesome.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/font-awesome-5/css/fontawesome-all.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('template/vendor/mdi-font/css/material-design-iconic-font.min.css')}}}" rel="stylesheet" media="all">
 
    <!-- Bootstrap CSS-->
    <link href="{{{ URL::asset('template/vendor/bootstrap-4.1/bootstrap.min.css')}}}" rel="stylesheet" media="all">
 
    <link href="{{{ URL::asset('template/vendor/animsition/animsition.min.css')}}}" rel="stylesheet" media="all">
 
    <!-- Main CSS-->
    <link href="{{{ URL::asset('template/css/theme.css')}}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{{ URL::asset('template/css/theme.css')}}}" rel="stylesheet" media="all">

    {{-- UPDATE CSS --}}
    <link href="{{{ URL::asset('assets/sweetalert2/dist/sweetalert2.min.css')}}}" rel="stylesheet" media="all">
    <link href="{{{ URL::asset('assets/datatables/datatables.min.css')}}}" rel="stylesheet" media="all">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="{{{ URL::asset("template/vendor/select2/select2.min.css")}}}" rel="stylesheet" />
    
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{{URL::asset('template/images/icon/algostudio_logo.png') }}}"
    />
    <style>
        .menu-sidebar .logo{
            background: #8fcb8f;
        }
        
        .header-mobile {
            background: #8fcb8f;
        }

        .header-mobile .hamburger{
            border-radius: 10px
        }

        .navbar-sidebar .navbar__list li.active > a {
            color: #8fcb8f
        }
        .navbar-sidebar .navbar__list li a:hover {
            color: #8fcb8f
        }
        .select2-container {
            width: 100% !important;
        }
        .main-content{
            padding-top: 60px
        }

        .card-header {
            background-color: rgb(143 202 142);
            height: 50px;
        }

        .card-header h4{
            color: white
        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>
    @yield('custom_styles')
</head>