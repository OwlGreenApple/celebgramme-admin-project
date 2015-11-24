<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='25' align='center'>Data belum di generate</td></tr>";
  } 
  $i=($page-1)*15 + 1;
  foreach ($data as $arr) {
?>
    <tr id="tr-{{$arr->id}}">
      <td>
        {{$i}}
      </td>
      <td style="text-align:center">
        {{$arr->no_order}}
      </td>
      <td style="text-align:right">{{number_format($arr->order_subtotal,0,'','.')}}</td>
      <td style="text-align:right">{{number_format($arr->order_shipment_fee,0,'','.')}}</td>
      <td style="text-align:right">{{number_format($arr->order_total,0,'','.')}}</td>
      <td style="text-align:center"> {{$arr->payment_method}} </td>
      <td style="text-align:center"> {{$arr->customer_id}} </td>
      <td style="text-align:center" class="shipping_no"> {{$arr->shipping_number}} </td>
      <td style="text-align:center"> {{$arr->invoice_id}} </td>
      <td style="text-align:center" id="order-status-{{$arr->id}}"> {{$arr->order_payment_status}} </td>
      <td style="text-align:center" class="shipping_status"> {{$arr->order_shipping_status}} </td>
      <td style="text-align:center" > {{$arr->created_at}} </td>
      <td style="text-align:center" >
        <input type="button" value="Edit Shipping" data-loading-text="Loading..." class="btn btn-primary button-confirm" id="button-confirm-{{$arr->id}}" onclick="callEdit('{{ $arr->id }}');"> 
        <input type="button" value="Detail" data-loading-text="Loading..." class="btn btn-info button-confirm" id="button-confirm-{{$arr->id}}" onclick="callDetail('{{ $arr->id }}');"> 
      </td>
    </tr>    

<?php 
    $i+=1;
  } 
?>

