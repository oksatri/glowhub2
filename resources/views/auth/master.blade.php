<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    @php
        $__settings = \App\Models\SiteSetting::first();
        $__favicon = null;
        if ($__settings && !empty($__settings->favicon)) {
            $__favicon = asset('uploads/' . $__settings->favicon);
        } elseif ($__settings && !empty($__settings->logo)) {
            $__favicon = asset('uploads/' . $__settings->logo);
        } else {
            $__favicon = asset('images/logo/logo_saja.png');
        }
    @endphp
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $__favicon }}">
    <title>GlowHub - Auth</title>
    <!-- Custom CSS -->
    <link href="admin/dist/css/style.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(admin/assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div style="position: absolute; top: 30px; left: 30px; z-index: 10;">
                <a href="{{ url('/') }}"
                    class="btn btn-info shadow rounded-pill px-4 py-2 d-inline-flex align-items-center"
                    style="font-weight: bold; border: none;">
                    <i class="fa fa-home mr-2"></i>
                    Home
                </a>
            </div>
            @yield('content')
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="admin/assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="admin/assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="admin/assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>
