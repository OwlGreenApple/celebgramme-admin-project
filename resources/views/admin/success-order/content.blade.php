<?php 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  $total = 0;
  foreach ($arr as $data_arr) {
?>
    <tr class="{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td>
        {{$data_arr->no_order}}
      </td>
      <td>
        {{$data_arr->order_type}}
      </td>
      <td>
        {{$data_arr->order_status}}
      </td>
      <td>
        {{number_format($data_arr->total,0,'','.')}}
      </td>
      <td>
        {{number_format($data_arr->discount,0,'','.')}}
      </td>
      <td>
        {{$data_arr->updated_at}}
      </td>
    </tr>    

<?php 
    $i+=1;
    $total = $total + ($data_arr->total-$data_arr->discount);
  } 
  }
?>

<input type="hidden" name="total" id="total" value="<?php echo number_format($total); ?>">

<script>
  $(document).ready(function(){
  });

</script>   

