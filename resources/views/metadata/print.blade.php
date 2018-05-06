@extends('layouts.app')
@push('head_scripts')
<link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/skins/_all-skins.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
@endpush
@push('body_class','skin-custom sidebar-mini')
@section('content')

	<section class="content">
		<div class="box">
			<table class="table">
				<thead>
					<tr>
					<td>unit label</td>
					<td>mac</td>
					<td>sensor_type</td>
					<td>sensor_value</td>
					<td>created_at</td>
					</tr>
				</thead>
				<tbody>
					@foreach($metadatas as $metadata)
					<tr>
					<td>{{$metadata->unit->label}}</td>
					<td>{{$metadata->mac}}</td>
					<td>{{$metadata->sensor_type}}</td>
					<td>{{$metadata->sensor_value}}</td>
					<td>{{$metadata->created_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>	
	</section> 

@endsection
@push('footer_scripts')
<script src="{{ asset('assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script>
      window.print();
 window.close();
</script>
@endpush

