@push('before_style')
<script>window._user = @json(Auth::user())</script>
<style>
.container{width: auto !important ;}
</style>
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@extends('layouts.dashboard')
@section('content-header')
<h1>
 Observation 
  <small>Patient Observable Reactive data log</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>e-Patient</a></li>
  <li><a href="{{ route('observe') }}">Observation</a></li>
  <li class="active">View</li>
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

<script>
  $(function () {
    $('#ex1').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
  })
</script>
@endpush
