<html>
	<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Register</title>
		<script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
	</head>
	<body>
		{!! Form::open(array('url'=>URL::ROUTE('auth.register'),'method'=>'post')) !!}
			{!! csrf_field() !!}
			@if (!$user_data['social_login'])
				<label for="username">Username : </label>
				<input type="text" id="username" name="cust[username]" value="{{ $user_data['username'] }}">
				<br />
			@else
				{!! Form::hidden('social_token',$user_data['social_token']) !!}
			@endif
			<label for="email">Email : </label>
			<input type="email" id="email" name="cust[email]" value="{{ $user_data['email'] }}">
			<br />
			<label for="password">Password : </label>
			<input type="password" id="password" name="cust[password]">
			<br />
			<label for="password_confirmation">Konfirmasi Password : </label>
			<input type="password" id="password_confirmation" name="cust[password_confirmation]">
			<br />
			<label for="customer_name">Nama Customer : </label>
			<input type="text" id="customer_name" name="cust[customer_name]" value="{{ $user_data['customer_name'] }}">
			<br />
			<label for="customer_gender">Jenis kelamin : </label>
			@if ($user_data['customer_gender'] == 1)
				<input type="radio" value="1" name="cust[customer_gender]" id="gender_male" checked> Laki-laki
				<input type="radio" value="0" name="cust[customer_gender]" id="gender_female"> Perempuan
			@else
				<input type="radio" value="1" name="cust[customer_gender]" id="gender_male"> Laki-laki
				<input type="radio" value="0" name="cust[customer_gender]" id="gender_female" checked> Perempuan
			@endif
			<br />
			<label for="customer_hp">Nomer HP : </label>
			<input type="text" id="customer_hp" name="cust[customer_hp]" value="{{ $user_data['customer_hp'] }}">
			<div class="g-recaptcha" data-sitekey="6LeWdg4TAAAAAL2iVmfwndI6FPqbyWfXsl5-qQgz"></div>
			<br />
			{!! Form::submit('Register') !!}
			@if (!$user_data['social_login'])
				<a href="{{ url('auth/google/redirect') }}">Google Signup</a>
				<a href="{{ url('auth/facebook/redirect') }}">Facebook Signup</a>
			@endif
		{!! Form::close() !!}
	</body>
</html>
