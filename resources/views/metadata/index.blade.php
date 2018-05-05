@push('before_style')
<style>
  .container{width: auto !important ;}
</style>
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@extends('layouts.dashboard')
@section('content-header')
<h1>
        Patient Data Log
        <small>Observational patient data log </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>e-Patient</a></li>
        <li><a href="{{ route('metadata') }}">Data</a></li>
        <li class="active">Log</li>
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
