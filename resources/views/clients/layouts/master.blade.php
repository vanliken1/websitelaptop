<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$meta_title}} </title>
  <meta name="description" content="{{$meta_desc}} ">
  <meta name="keywords" content="{{$meta_keyword}}" />
  <link rel="canonical" href="{{$url_canonical}}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="/asset/client/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="/asset/client/vendor/font-awesome/css/font-awesome.min.css">
  <!-- Google fonts - Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700">
  <!-- owl carousel-->
  <link rel="stylesheet" href="/asset/client/vendor/owl.carousel/assets/owl.carousel.css">
  <link rel="stylesheet" href="/asset/client/vendor/owl.carousel/assets/owl.theme.default.css">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="/asset/client/css/style.default.css" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="/asset/client/css/custom.css">
  <!-- Favicon-->
  <link rel="shortcut icon" href="/asset/client/img/haovan.png">
  <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body>
  <!-- navbar-->
  <header class="header mb-5">
    <!--
      *** TOPBAR ***
      _________________________________________________________
      -->
    @include("clients.layouts.topbar")
    <!-- --topbar-- -->
    @include("clients.layouts.menu")
    @yield('content')
    <!--
    *** FOOTER ***
    _________________________________________________________
    -->
    @include("clients.layouts.footer")
    <!-- /#footer-->
    <!-- *** FOOTER END ***-->


    <!--
    *** COPYRIGHT ***
    _________________________________________________________
    -->

    <!-- *** COPYRIGHT END ***-->
    <!-- JavaScript files-->
    @include("clients.layouts.script")
    @yield('script')
</body>

</html>