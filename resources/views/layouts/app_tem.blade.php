<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSettingValueByKeyCache('name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">

    
    <link rel="stylesheet" href="{{ asset('vendor/adminLTE/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/css/skins/_all-skins.min.css"-->

    <!-- Ionicons -->
    <style type="text/css">
        .trSelected{
            background-color:#367fa9;
            color:white;
        }
        .box-body{
            padding: 0;
        }
    </style>
    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
    <style type="text/css">
        body{max-width: 1500px; margin: 0 auto;}
    </style>

    @yield('content')
 

    <!-- jQuery 2.1.4 -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminLTE/js/app.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/layer/layer.js') }}"></script>
{{--     <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>