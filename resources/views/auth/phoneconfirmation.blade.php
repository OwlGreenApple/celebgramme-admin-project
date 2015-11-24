<html>
	<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Register</title>
	</head>
	<body>
		{!! Form::open(array('url'=>URL::ROUTE('auth.phoneconfirmation'),'method'=>'post')) !!}
			{!! csrf_field() !!}
			@if (!$user_data['social_login'])
				Username : {{ $user_data['username'] }} <br />
			@endif
			Email : {{ $user_data['email'] }} <br />
			Password : ******** <br />
			Nama Customer : {{ $user_data['customer_name'] }} <br />
			Jenis Kelamin : 
			@if ($user_data['customer_gender'] == 1)
				Laki - laki
			@else
				Perempuan
			@endif
			<br />
			Nomer HP : {{ $user_data['customer_hp'] }} <br />
			<label for="confirmation_code">Kode Konfirmasi : </label>
			<input type="text" id="confirmation_code" name="confirmation_code" value="">
			<br />
			{!! Form::submit('Proses') !!}
		{!! Form::close() !!}
	</body>
</html>
