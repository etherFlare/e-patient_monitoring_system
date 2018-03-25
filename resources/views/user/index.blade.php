@push('before_style')
<style>
	.container{width: auto !important ;}
</style>
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@extends('layouts.dashboard')
@section('content-header')
<h1>
        Accounts
        <small>e-patient nurses, doctors , administrators and developer accounts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>e-Patient</a></li>
        <li><a href="#">Accounts</a></li>
        <li class="active">List</li>
      </ol>
@endsection
@section('main-content')
<div id="app"></div>	
@endsection
@push('footer_scripts')
<script src="{{ asset('assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"> </script>
<script src="{{ asset('assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"> </script>
<script src="{{ asset('assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"> </script>
<script src="{{ asset('assets/adminlte/bower_components/fastclick/lib/fastclick.js') }}"> </script>
@endpush
