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
						<td>email</td>
						<td>first_name</td>
						<td>middle_name</td>
						<td>last_name</td>
						<td>contact_number</td>
						<td>comment</td>
						<td>roles</td>
						<td>created_at</td>
						<td>updated_at</td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->email}}</td>
						<td>{{$user->first_name}}</td>
						<td>{{$user->middle_name}}</td>
						<td>{{$user->last_name}}</td>

						<td>{{$user->contact_number}}</td>
						<td>{{$user->comment}}</td>
						<td>{{implode(', ', $user->roles->pluck('title')->all())}}</td>
						<td>{{$user->created_at}}</td>
						<td>{{$user->updated_at}}</td>
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
      // window.print();
 // window.close();
</script>
@endpush

