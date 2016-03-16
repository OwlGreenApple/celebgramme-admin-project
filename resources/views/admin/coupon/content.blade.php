<?php 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$data_arr->coupon_code}}
      </td>
      <td align="center">
        {{$data_arr->coupon_value}}
      </td>
      <td align="center">
        {{$data_arr->coupon_percent}}
      </td>
      <td align="center">
        <?php 
					if ($data_arr->package_id==0) {
						echo "all";
					} else {
						
					}
				?>
      </td>
      <td align="center">
        {{$data_arr->valid_until}}
      </td>
      <td align="center">
        <input type="button" class="btn btn-info btn-update" value="update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" 
        data-coupon-code="{{$data_arr->coupon_code}}" data-coupon-value="{{$data_arr->coupon_value}}" data-valid-until="{{$data_arr->valid_until}}"
        >
      </td>
    </tr>    

<?php 
    $i+=1;
  } 
  }
?>
<script>
  $(document).ready(function(){
  });

</script>		

