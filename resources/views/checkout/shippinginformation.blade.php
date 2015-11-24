<html>
	<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Login</title>
	</head>
	<body>
		INI SHIPPING INFORMATION
		<br />
		<br />
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
