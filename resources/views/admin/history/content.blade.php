<?php 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr>
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$data_arr->url_photo}}
      </td>
      <td align="center">
        {{$data_arr->likes}}
      </td>
      <td align="center">
        {{$data_arr->email}}
      </td>
      <td align="center">
        {{$data_arr->fullname}}
      </td>
      <td align="center">
        {{$data_arr->phone_number}}
      </td>
      <td align="center">
        <?php if ($data_arr->status) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon" data-id="{{$data_arr->id}}"></i>
        <?php } ?>
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

