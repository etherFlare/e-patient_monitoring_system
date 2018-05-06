<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 

<meta name="viewport" content="width=device-width, initial-scale=1">
 
<title>{{ config('', 'e-patient') }}</title>
 
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/custom-skin.css') }}">
 
</head>
<body>
  <div class="printable">

	<div class="container">
		
<table class="table">
		<thead>
			<tr>
				<td>ID</td>
			</tr>
		</thead>
		<tbody>
			
		@foreach($patients as $patient)
		<tr>
			<td>{{$patient->id}}</td>
		</tr>
	@endforeach
		</tbody>
	</table>

	</div>

 
  </div>
   <script>
     window.print();
window.close();
   </script>
</body>
</html>