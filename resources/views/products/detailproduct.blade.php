<html>
	<head>
		<meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Axiasmart - Register</title>
		<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
		
		<script type="text/javascript">
			function getCartCount(){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: '{{ url("cart/getcartcount") }}',
					type: 'get',
					success: function(data){
						$('#cart_qty').html(data);
					}
				});
			}
			$(document).ready(function(){
				getCartCount();
			});
		</script>
	</head>
	<body>
			Supplier : {{ $prod_data['supplier_company_name'] }} <br />
			Kategori : {{ $prod_data['name'] }} <br />
			Nama : {{ $prod_data['product_name'] }} <br />
			Harga : {{ $prod_data['product_price'] }} <br />
			Kondisi : {{ $prod_data['product_condition'] }} <br />
			Lokasi : {{ $prod_data['product_location'] }} <br />
			Keterangan : {{ $prod_data['product_description'] }} <br />
			Stok : {{ $prod_data['product_stock'] }} <br />
			Berat : {{ $prod_data['product_weight'] }} <br />
			<a href="{{ url('cart/addproduct') }}?pid={{ $prod_data['id'] }}&qty=1">Beli</a> <br />
			<br />
			<a href="{{ url('cart') }}">Your Cart: <span id="cart_qty">0</span></a>
	</body>
</html>
