<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <style>



    </style>
	</head>
	<body style="padding: 0;position:relative; margin : 0 auto;	 width: 800px;">
    <?php 
      use App\Helpers\GeneralHelper; 
      use App\Models\Order;
      use App\Models\Order_detail;
      use App\Models\Suppliers;
    ?>
		<div id="background" style="left: 0px; top: 0px; position: relative; margin-left: auto; margin-right: auto; min-height : 600px;overflow: hidden;z-index:0;">
			<div id="RincianPesanan" style="left: 104px; top: 570px; position: absolute; width: 210px; height: 22px; z-index:33;">
        <img src="{{ asset('images/invoice/RincianPesanan.png')}}">
      </div>
			<div id="striporange" style="left: 88px; top: 563px; position: absolute; width: 8px; height: 34px; z-index:34;">
      <img src="{{ asset('images/invoice/striporange.png')}}"></div>
			<div id="gariscopy3" style="left: 134px; top: 498px; position: absolute; width: 610px; height: 1px; z-index:35;">
        <img src="{{ asset('images/invoice/gariscopy3.png')}}">
      </div>
			<div id="cekstatusorder" style="left: 213px; top: 396px; position: absolute; width: 371px; height: 47px; z-index:36;">
        <a href="{{$url}}"><img src="{{ asset('images/invoice/cekstatusorder.png')}}"></a></div>
			<div id="Pantaupesananandaden" style="left: 149px; top: 313px; position: absolute; width: 498px; height: 46px; z-index:37;"><img src="{{ asset('images/invoice/Pantaupesananandaden.png')}}"></div>
			<div id="Pesananandatelahkami" style="left: 133px; top: 248px; position: absolute; width: 530px; height: 34px;z-index:38;"><img src="{{ asset('images/invoice/Pesananandatelahkami.png')}}"></div>
			<div id="Layer8" style="left: 61px; top: 168px; position: absolute; width: 703px; height: 40px; z-index:39;"><img src="{{ asset('images/invoice/Layer8.png')}}"></div>
			<div id="logo" style="left: 231px; top: 74px; position: absolute; width: 339px;height: 80px;z-index:40;"><img src="{{ asset('images/invoice/logo.png')}}"></div>
		</div>
    <div class="div-order" style="position:relative;  margin-left: 86px;  margin-top: 20px;width:600px;">
    
      <!-- dalam looping supplier-->
      <?php 
      $total_price = 0; $total_discount = 0; $total_shipment = 0;
      $orders = Order::where("no_order","=",$order_number)->get();
      foreach ( $orders as $order ) {
        $supplier = Suppliers::find($order->supplier_id);
        $total_shipment += $order->order_shipment_fee;
      ?>
      <div class="order-supplier" style="position : relative; display: block;">
        <h4 class="header-order-detail" style="display:block; margin-bottom:12px;font-family:'Open Sans';font-family:'Open Sans';font-size:25px;margin:0px;">Dikirim dari {{$supplier->supplier_alias}}</h4>
        
        <!-- dalam looping order detail-->
        <?php 
        $order_details = Order_detail::where("order_id","=",$order->id)->get();
        foreach ($order_details as $order_detail) {
          $total_price += $order_detail->product_price;
          $total_discount += $order_detail->product_discount;
        ?>
        <div class="order-detail" style="display:block;height:120px;">
          <div class="fl div-image" style="float:left;display: inline-block;">
          <?php $path = "/../../general/images/orders/".$order_number."/".$order_detail->product_image; ?>
          <img src ="{{asset($path)}}" class="image-order-detail fl" style="float:left;width : 115px;height:110px;">
          </div>
          <div class="fl div-description" style="float:left;display: inline-block;margin-left: 20px;">
            <h5 class="product-name" style="display:inline-block; width:100%;font-weight:Bold;font-family:'Open Sans';font-size:18px;margin:0px;float:left;">{{$order_detail->product_name}}</h5>
            <div class="product-price" style="display:inline-block; width:100%; height:65px;">
              <h6 style="font-family:'Open Sans';font-size:17px;margin:0px;"<?php if ($order_detail->product_discount>0) { echo 'style="text-decoration: line-through;"'; } ?>>
              Rp. {{number_format($order_detail->product_price,0,'','.')}}</h6>
              <?php if ($order_detail->product_discount>0) { ?>
              <h6 style="font-family:'Open Sans';font-size:17px;margin:0px;"> Rp. {{number_format($order_detail->product_price-$order_detail->product_discount,0,'','.')}}</h6>
              <?php } ?>
            </div>
            <p class="product-subtotal" style="display:inline-block;font-family:'Open Sans';margin:0px;">Subtotal : </p><h6 style="font-family:'Open Sans';font-size:17px;margin:0px;display:inline-block;" class="price-subtotal">Rp. {{number_format(($order_detail->product_price - $order_detail->product_discount)*$order_detail->product_quantity,0,'','.')}}</h6>
          </div>
          <div class="fr div-qty" style="float:right;display: inline-block;">
            <input type="text" value="{{$order_detail->product_quantity}}" class="input-invoice" disabled style="resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;">
          </div>
          <div class="fn" style="float:none;"></div>
        </div>
        <?php } ?>
        
        <div class="div-shipping" style="display : block; margin-bottom: 10px;height:20px;margin-top:10px;">
          <p class="shipping fl" style="display:inline-block;font-family:'Open Sans';margin:0px;float:left; margin-top:5px;">Kurir Pengiriman : </p> 
          <input type="text" value="{{$order->shipping_courier}}" disabled class="input-invoice fl" style="margin-left:180px; float:left;resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;">
          <input type="text" value="{{$order->shipping_method}}" disabled class="input-invoice fl" style="margin-left:50px; float:left;resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;">
          <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($order->order_shipment_fee,0,'','.')}}</h6>
          <div class="fn" style="float:none;"></div>
        </div>
      </div>
      <?php } ?>


      <div class="footer-order" style="display : block; margin-top:50px; height:190px;">
        <div class="footer-description" style="display : block; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Total Harga </p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_price,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="display : block; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Total Discount </p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_discount,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="display : block; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Biaya Kirim</p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_shipment,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="display : block; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;margin-top:5px; float:left;">Grand Total </p> 
          <h4 class="total-price bold orange fr" style="font-family:'Open Sans';font-family:'Open Sans';font-size:25px;margin:0px; float:right; color:#ef7025;">Rp. {{number_format($total_price+$total_shipment-$total_discount,0,'','.')}}</h4> <div class="fn" style="float:none;"></div>
        </div>
      </div>
    
    
    
    </div>
    
			<div id="Layer4" style="left: -7px; bottom: 0px; position: absolute; width: 826px; height: 35px; z-index:2;">
        <img src="{{ asset('images/invoice/Layer4.png')}}">
      </div>
			<div id="CopyrightAxiamarketc" style="left: 322px; bottom: 11px; position: absolute; width: 167px; height: 9px; z-index:3;">
      <img src="{{ asset('images/invoice/CopyrightAxiamarketc.png')}}"></div>
 </body>
 </html>