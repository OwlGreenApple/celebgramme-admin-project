Terima kasih, <br>
Admin telah MENERIMA KONFIRMASI PEMBAYARAN anda <br>
berikut ini adalah INVOICE PEMBAYARAN anda <br>
<br>
<strong>No Invoice : </strong> {{$no_invoice}}<br>
<strong>Anda membayar via : </strong> {{$order_type}} <br>
<strong>Paket : </strong> 
<?php 
	if ($order->type == "daily-activity") {
		echo $package->package_name;
	}
	else if ($order->type == "max-account") {
		echo $order->added_account." Akun";
	}
?>
<br>
<strong>Harga Paket : </strong> {{$order->total}} <br>
<strong>Discount : </strong> {{$coupon_value}} <br>
<strong>Total : </strong> {{$invoice->total}} <br>
<br>
Silahkan akses ke user Dashboard<br>
Login ke https://celebgramme.com/celebgramme/<br>
<br>
Dan Setup Settings Instagram Auto Manage anda.<br>
<br>
Team kami selalu siap membantu anda,<br>
<br>
<br>
Salam hangat, <br>
<br>
Celebgramme.com

