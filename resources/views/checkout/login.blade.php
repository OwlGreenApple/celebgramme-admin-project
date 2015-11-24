<html>
	<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Login</title>
	</head>
	<body>
		{!! Form::open(array('url'=>URL::ROUTE('auth.login'),'method'=>'post')) !!}
			{!! csrf_field() !!}
			{!! Form::label('username','Username : ') !!}
			{!! Form::text('username',Input::old('username'),array('placeholder'=>'username')) !!}
			<br />
			{!! Form::label('password','Password : ') !!}
			{!! Form::text('password',Input::old('password'),array('placeholder'=>'password')) !!}
			<br />
			<input type="checkbox" name="remember"> Remember me
			<br />
			{!! Form::hidden('r', url('checkout/shippinginformation')) !!}
			{!! Form::submit('Log in') !!}
			<a href="{{ url('auth/google/redirect').'?r='.urlencode(url('checkout/shippinginformation')) }}">Google Login</a>
			<a href="{{ url('auth/facebook/redirect').'?r='.urlencode(url('checkout/shippinginformation')) }}">Facebook Login</a>
		{!! Form::close() !!}
		
		<table id="cart_detail" >
			<thead>
				<tr>
					<td>Kode Product</td>
					<td>Nama Product</td>
					<td>Qty</td>
				</tr>
			</thead>
			<tbody>
				@if (count($cart_data) > 0)
					@for ($i = 0; $i < count($cart_data); $i++)
						<tr>
							<td>{{ $cart_data[$i]['product']['id'] }}</td>
							<td>{{ $cart_data[$i]['product']['product_name'] }}</td>
							<td>{{ $cart_data[$i]['qty'] }}</td>
						</tr>
					@endfor
				@else
					<tr>
						<td colspan="4">Cart masih kosong</td>
					</tr>
				@endif
			</tbody>
		</table>
	</body>
</html>
