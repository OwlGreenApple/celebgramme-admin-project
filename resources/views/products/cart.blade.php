<html>
	<head>
		<meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Register</title>
		<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
		
		<script type="text/javascript">
			function changeCartQty(pid, qty){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: '{{ url("cart/changecartqty") }}',
					type: 'post',
					data: {
						pid: pid,
						qty: qty,
					},
					success: function(data){
						if (data == 'success'){
							alert('ok');
						}
					}
				});
			}
			$(document).ready(function(){
				console.log('HELLOW WORLD');
				$('[ax-id] input').blur(function(e){
					e.preventDefault();
					changeCartQty($(this).parents('tr').attr('ax-id'), $(this).val());
				});
				$('a[ax-button="remove"]').click(function(e){
					e.preventDefault();
					changeCartQty($(this).parents('tr').attr('ax-id'), 0);
					$(this).parents('tr').remove();
				});
			});
		</script>
	</head>
	<body>
			<table id="cart_detail" >
				<thead>
					<tr>
						<td>Kode Product</td>
						<td>Nama Product</td>
						<td>Qty</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@if (count($cart_data) > 0)
						@for ($i = 0; $i < count($cart_data); $i++)
							<tr ax-id="{{ $cart_data[$i]['product']['id'] }}">
								<td>{{ $cart_data[$i]['product']['id'] }}</td>
								<td>{{ $cart_data[$i]['product']['product_name'] }}</td>
								<td><input type="text" value="{{ $cart_data[$i]['qty'] }}"></td>
								<td><a ax-button="remove" href="javasript:void(0)">X</a></td>
							</tr>
						@endfor
					@else
						<tr>
							<td colspan="4">Cart masih kosong</td>
						</tr>
					@endif
				</tbody>
			</table>
			<a href="{{ url('checkout/login') }}">Checkout</a>
		</form>
	</body>
</html>
