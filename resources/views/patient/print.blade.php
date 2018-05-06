@extends('layouts.app')
@push('head_scripts')
<link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/skins/_all-skins.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
@endpush
@push('body_class','skin-custom sidebar-mini')
@section('content')

	<section class="content">
		<div class="box">
			<table class="table" style="font-size: 10px">
				<thead>
					<tr>
						<td>first_name</td>
						<td>middle_name</td>
						<td>last_name</td>
						<td>gender</td>
						<td>age</td>
						<td>location name</td>
						<td>home_address</td>
						<td>contact_number</td>
						<td>contact_person</td>
						<td>unit label</td>
						<td>unit mac_address</td>
						<td>unit oximeter_delay</td>
						<td>unit bp_delay</td>
						<td>unit thermometer_delay</td>
						<td>comment</td>
						<td>created_at</td>
						<td>updated_at</td>
					</tr>
				</thead>
				<tbody>
					@foreach($patients as $patient)
					<tr>
						<td>{{$patient->first_name}}</td>
						<td>{{$patient->middle_name}}</td>
						<td>{{$patient->last_name}}</td>
						<td>{{$patient->gender}}</td>
						<td>{{$patient->age}}</td>
						<td>{{$patient->location->name}}</td>
						<td>{{$patient->home_address}}</td>
						<td>{{$patient->contact_number}}</td>
						<td>{{$patient->contact_person}}</td>
						<td>{{$patient->unit->label}}</td>
						<td>{{$patient->unit->mac_address}}</td>
						<td>{{$patient->unit->oximeter_delay}}</td>
						<td>{{$patient->unit->bp_delay}}</td>
						<td>{{$patient->unit->thermometer_delay}}</td>
						<td>{{$patient->comment}}</td>
						<td>{{$patient->created_at}}</td>
						<td>{{$patient->updated_at}}</td>
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

