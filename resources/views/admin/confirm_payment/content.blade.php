<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='25' align='center'>Data belum di generate</td></tr>";
  } 
  $i=($page-1)*15 + 1;
  foreach ($data as $arr) {
?>
    <tr>
      <td>
        {{$i}}
      </td>
      <td style="text-align:center">
        {{$arr->no_order}}
      </td>
      <td style="text-align:center"> {{$arr->name}} </td>
      <td style="text-align:center"> {{$arr->payment_method}} </td>
      <td style="text-align:right">{{number_format($arr->amount,0,'','.')}}</td>
      <td style="text-align:center"> {{$arr->description}} </td>
      <td style="text-align:center"> {{$arr->image}} </td>
      <td style="text-align:center" > {{$arr->created_at}} </td>
      
      <td align="center" id="status-{{$arr->id}}">
      
      
        <?php 
          if ($arr->payment_method=='bank_transfer') { 
            if ($arr->confirm_status) { ?>
              <i class="checked-icon"></i>
        <?php } else { ?>
              <i class="x-icon" data-id="{{$arr->id}}" data-total="{{$arr->amount}}"></i>
        <?php 
            }
          }
          
          
          
          if ($arr->payment_method=='veritrans') { 
            if ($arr->confirm_status) { 
        ?>
              <i class="checked-icon"></i>
        <?php } else { ?>
              <input type="button" value="Accept" class="btn btn-success btn-veritrans-accept" data-id="{{$arr->id}}" data-total="{{$arr->amount}}"> 
              <input type="button" value="Deny" class="btn btn-danger btn-veritrans-deny" data-id="{{$arr->id}}">
        <?php 
            }
          }
        ?>
        
        
      </td>
      
      <td style="text-align:center">
        <input type="button" value="Check Order" data-loading-text="Loading..." class="btn btn-primary button-confirm" data-id="{{$arr->id}}"  onclick="callEditConfirm('{{ $arr->no_order }}');"> 
      </td>
    </tr>    

<?php 
    $i+=1;
  } 
?>

