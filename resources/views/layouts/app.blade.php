<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!--  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
-->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('', 'e-patient') }}</title>
    @stack('before_style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/custom-skin.css') }}">
    
    @stack('head_scripts')
    <script>
    window.Laravel = 
        <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]);?>
</script> 
</head>
<body class="hold-transition @stack('body_class')" >
@yield('content')   
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/jquery/2/jquery-2.2.4.min.js') }}"></script>
<script src="{{ url('assets/sweetalert-master/dist/sweetalert2.min.js') }}"></script>
@stack('footer_scripts')
</body>
</html>
