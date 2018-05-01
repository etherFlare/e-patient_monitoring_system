@extends('layouts.app')
@push('head_scripts')
<link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/skins/_all-skins.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
@endpush
@push('body_class','skin-custom sidebar-mini')
@section('content')
<div class="wrapper">
 <header class="main-header">
    <a href="#" class="logo">
      <span class="logo-mini"><b>E</b>Pt</span>
      <span class="logo-lg"><b>e-Patient</b>-local</span>
    </a>
    <nav class="navbar navbar-static-top">
     @include('layouts.notification')
    </nav>
  </header>
	<aside class="main-sidebar">
		<section class="sidebar">
			@include('layouts.sidebar-menu')
		</section>
	</aside>
	<div class="content-wrapper">
		<section class="content-header">
			@yield('content-header')
		</section>
		<section class="content">
			@yield('main-content')
		</section>
	</div>
	<footer class="main-footer">
		@stack('main-footer')
		 <div class="pull-right hidden-xs">
      <b>Version</b>Alpha
    </div>
    <strong>Copyright &copy; 2017-2018 <a href="">only the strong survives</a>.</strong> All rights
    reserved.
	</footer>
</div>
@endsection
@push('footer_scripts')
<script src="{{ asset('assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/bower_components/fastclick/lib/fastclick.js') }}"></script>
@endpush