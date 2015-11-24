<!DOCTYPE html>
<html>
    <head>
			<title>Laravel</title>

			<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

			<style>
					html, body {
							height: 100%;
					}

					body {
							margin: 0;
							padding: 0;
							width: 100%;
							display: table;
							font-weight: reguler;
							font-family: 'Lato';
					}

					.container {
							text-align: center;
							display: table-cell;
							vertical-align: middle;
					}

					.content {
							text-align: center;
							display: inline-block;
					}

					.title {
							font-size: 96px;
					}
		
					table tr td{
						border: 1px solid #000;
						padding: 10px;
						font-family: verdana;
						border:1px solid #444;
					}
			</style>
				
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
        <div class="container">
            <div class="content">
							<div class="title">Laravel 5</div>
							@if (Auth::check())
								<a href="{{ url('auth/logout') }}">Logout</a>
							@else
								<a href="{{ url('login') }}">Login</a>
								<a href="{{ url('register') }}">Register</a>
							@endif
							<a href="{{ url('admin') }}">admin</a>
							<a href="{{ url('cart') }}">Your Cart: <span id="cart_qty">0</span></a>
							@if(count($suppliers) > 0)
								<table>
									<tr>
										<td>Nama</td>
										<td>Alamat</td>
										<td>Telp</td>
									</tr>
									@foreach($suppliers as $supplier)
										<tr>
											<td>{{ $supplier->supplier_company_name }}</td>
											<td>{{ $supplier->supplier_address }}</td>
											<td>{{ $supplier->supplier_phone }}</td>
										</tr>
									@endforeach
								</table>
							@endif
            </div>
        </div>
    </body>
</html>
