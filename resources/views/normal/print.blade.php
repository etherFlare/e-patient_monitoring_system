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
					<td>patientfirst_name0</td>
					<td>patientmiddle0_name</td>
					<td>patientlast_na0me</td>
					<td>patient comm0ent</td>
					<td>type name</td>
					<td>upper_limit</td>
					<td>lower_limit</td>
					<td>created_at</td>
					<td>updated_at</td>
					</tr>
				</thead>
				<tbody>
					@foreach($normals as $normal)
					<tr>
					<td>{{$normal->patient->first_name}}</td>
					<td>{{$normal->patient->middle_name}}</td>
					<td>{{$normal->patient->last_name}}</td>
					<td>{{$normal->patient->comment}}</td>
					<td>{{$normal->type->name}}</td>
					<td>{{$normal->upper_limit}}</td>
					<td>{{$normal->lower_limit}}</td>
					<td>{{$normal->created_at}}</td>
					<td>{{$normal->updated_at}}</td>
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

