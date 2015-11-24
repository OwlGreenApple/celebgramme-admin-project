<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	</head>
	<body style="padding: 0; margin : 0 auto;	 width: 800px;">
    <?php 
      use App\Helpers\GeneralHelper; 
      use App\Models\Order;
      use App\Models\Order_detail;
      use App\Models\Suppliers;
    ?>
  	<div id="logo" style="margin-left: 231px; margin-top: 74px; display:block; width: 339px;height: 80px;z-index:40;">
      <img src="{{ asset('images/invoice/logo.png')}}">
    </div>
    <div id="Pesananandatelahkami" style="margin-left: 133px; margin-top:174px; width: 530px; height: 34px;z-index:38;">
      <img src="{{ asset('images/invoice/Pesananandatelahkami.png')}}">
    </div>
    <div id="Pantaupesananandaden" style="margin-left: 149px; margin-top:65px; width: 498px; height: 46px; z-index:37;">
      <img src="{{ asset('images/invoice/Pantaupesananandaden.png')}}">
    </div>
    <div id="cekstatusorder" style="margin-left: 213px; margin-top:83px; width: 371px; height: 47px; z-index:36;">
      <a href="{{$url}}"><img src="{{ asset('images/invoice/cekstatusorder.png')}}"></a>
    </div>
    <div id="RincianPesanan" style="margin-left: 85px; margin-top:174px; width: 210px; height: 22px; z-index:33;">
      <img src="{{ asset('images/invoice/RincianPesanan.png')}}">
    </div>
    <div class="div-order" style="margin-left: 86px;  margin-top: 20px;width:600px;">
    
      <!-- dalam looping supplier-->
      <?php 
      $total_price = 0; $total_discount = 0; $total_shipment = 0;
      $orders = Order::where("no_order","=",$order_number)->get();
      foreach ( $orders as $order ) {
        $supplier = Suppliers::find($order->supplier_id);
        $total_shipment += $order->order_shipment_fee;
      ?>
      <div class="order-supplier" style="display: block;margin-bottom:20px;">
        <h4 class="header-order-detail" style="display:block; margin-bottom:12px;font-family:'Open Sans';font-family:'Open Sans';font-size:25px;margin:0px;">Dikirim dari {{$supplier->supplier_alias}}</h4>
        
        <!-- dalam looping order detail-->
        <table>
        <?php 
        $order_details = Order_detail::where("order_id","=",$order->id)->get();
        foreach ($order_details as $order_detail) {
          $total_price += $order_detail->product_price;
          $total_discount += $order_detail->product_discount;
        ?>
        <tr style="height:120px;">
          <td class="fl div-image" style="float:left;width:120px;">
          <?php $path = "general/images/orders/".$order_number."/".$order_detail->product_image; ?>
          <img src ="{{asset($path)}}" class="image-order-detail fl" style="float:left;width : 115px;height:110px;">
          </td>
          <td class="fl div-description" style="margin-left: 20px;float:left;width:390px;">
            <h5 class="product-name" style="width:100%;font-weight:Bold;font-family:'Open Sans';font-size:18px;margin:0px;float:left;">{{$order_detail->product_name}}</h5>
            <div class="product-price" style="width:100%; height:65px;">
              <h6 style="font-family:'Open Sans';font-size:17px;margin:0px;<?php if ($order_detail->product_discount>0) { echo 'text-decoration: line-through;'; } ?>">
              Rp. {{number_format($order_detail->product_price,0,'','.')}}</h6>
              <?php if ($order_detail->product_discount>0) { ?>
              <h6 style="font-family:'Open Sans';font-size:17px;margin:0px;"> Rp. {{number_format($order_detail->product_price-$order_detail->product_discount,0,'','.')}}</h6>
              <?php } ?>
            </div>
            <p class="product-subtotal" style="font-family:'Open Sans';margin:0px;">Subtotal : </p>
            <h6 style="font-family:'Open Sans';font-size:17px;margin:0px;" class="price-subtotal">Rp. {{number_format(($order_detail->product_price - $order_detail->product_discount)*$order_detail->product_quantity,0,'','.')}}</h6>
          </td>
          <td class="fr div-qty" style="float:right;">
            <input type="text" style="resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;" value="{{$order_detail->product_quantity}}" class="input-invoice" disabled="disabled">
          </td>
          <td style="float:none;">
          </td>
        </tr>
        <?php } ?>
        </table>
        
        <div class="div-shipping" style="width : 100%; margin-bottom: 10px;height:20px;margin-top:10px;">
          <p class="shipping fl" style="font-family:'Open Sans';margin:0px;float:left; margin-top:5px;">Kurir Pengiriman : </p> 
          <input type="text" value="{{$order->shipping_courier}}" disabled="disabled" class="input-invoice fl" style="margin-left:180px; float:left;resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;">
          <input type="text" value="{{$order->shipping_method}}" disabled="disabled" class="input-invoice fl" style="margin-left:50px; float:left;resize: none; overflow: auto; width: 50px; height: 30px; text-align: center;">
          <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($order->order_shipment_fee,0,'','.')}}</h6>
          <div class="fn" style="float:none;"></div>
        </div>
      </div>
      <?php } ?>


      <div class="footer-order" style="width : 100%; margin-top:50px; height:190px;">
        <div class="footer-description" style="width : 100%; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Total Harga </p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_price,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="width : 100%; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Total Discount </p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_discount,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="width : 100%; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;float:left;">Biaya Kirim</p> <h6 class="total-price bold fr" style="font-family:'Open Sans';font-size:17px;margin:0px;float:right;">Rp. {{number_format($total_shipment,0,'','.')}}</h6> <div class="fn" style="float:none;"></div>
        </div>
        <div class="footer-description" style="width : 100%; margin-top:3px; height:20px;">
          <p class="order-description fl" style="font-family:'Open Sans';margin:0px;margin-top:5px; float:left;">Grand Total </p> 
          <h4 class="total-price bold orange fr" style="font-family:'Open Sans';font-family:'Open Sans';font-size:25px;margin:0px; float:right; color:#ef7025;">Rp. {{number_format($total_price+$total_shipment-$total_discount,0,'','.')}}</h4> <div class="fn" style="float:none;"></div>
        </div>
      </div>
    
    
    
    </div>

			<div id="Layer4" style="width: 826px; height:40px; background-color:#0d4d94;">
        <div id="CopyrightAxiamarketc" style="width: 100%; height: 9px; padding-top: 10px; margin-left: 350px;">
        <img src="{{ asset('images/invoice/CopyrightAxiamarketc.png')}}"></div>
      </div>
 </body>
 </html>