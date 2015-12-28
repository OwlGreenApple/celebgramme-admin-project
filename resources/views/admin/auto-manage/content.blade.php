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
        {{$data_arr->insta_username}}
      </td>
      <td align="center">
        {{$data_arr->insta_password}}
      </td>
      <td align="center">
        <?php if ($data_arr->error_cred) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-error" data-id="{{$data_arr->setting_id}}"></i>
        <?php } ?>
      </td>
      <td align="center">
        {{$data_arr->description}}
      </td>
      <td align="center">
        {{$data_arr->updated_at}}
      </td>
      <td align="center">
        <?php if ($data_arr->type=="success") { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-status" data-id="{{$data_arr->id}}"></i>
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

