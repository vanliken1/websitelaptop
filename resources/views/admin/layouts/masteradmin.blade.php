<!DOCTYPE html>
<html lang="en">

<head>
    <!-- {{asset('public/backend/vendor/jquery/jquery.min.js')}} -->
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <!-- Favicon -->
    <link href="/asset/admin/img/haovan.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/asset/admin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/asset/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/asset/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/asset/admin/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="/asset/admin/ckeditor/ckeditor.js"></script>
    <script src="/asset/admin/ckfinder/ckfinder.js"></script>
    <!-- <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <style>
        .swal-popup {
            width: 200px;
            padding: 10px;
        }

        .swal-title {
            font-size: 24px;
            font-weight: bold;
        }

        .swal-content {
            font-size: 14px;
        }
    </style> -->
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->


        <!-- Sidebar Start -->
        @include("admin.layouts.sidebar")
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include("admin.layouts.navbar")
            <!-- Navbar End -->
            @yield('content')




            <!-- Footer Start -->
            @include("admin.layouts.footer")
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    @include("admin.layouts.script")
    @yield('script')

    <!-- Template Javascript -->

</body>

</html>