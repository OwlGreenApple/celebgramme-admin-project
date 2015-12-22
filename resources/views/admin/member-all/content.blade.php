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
        {{$data_arr->email}}
      </td>
      <td align="center">
        {{$data_arr->name}}
      </td>
      <td align="center" class="total-balance">
        {{$data_arr->balance}}
      </td>
      <td align="center">
        {{$data_arr->valid_until}}
      </td>
      <td align="center">
        <?php if ($data_arr->status_free_trial) {echo"yes";} else {echo"no";} ?>
      </td>
      <td align="center" class="total-auto-manage">
        <?php 
        $t = $data_arr->active_auto_manage;
        $days = floor($t / (60*60*24));
        $hours = floor(($t / (60*60)) % 24);
        $minutes = floor(($t / (60)) % 60);
        $seconds = floor($t  % 60);
        echo $days." days ".$hours." hours ".$minutes." minutes ".$seconds."seconds";

        ?>
      </td>
      <td align="center">
        <input type="button" class="btn btn-info btn-daily-like" value="Give likes" data-toggle="modal" data-target="#myModalDailyLikes" data-id="{{$data_arr->id}}" >
        <input type="button" class="btn btn-info btn-auto-manage" value="Give times" data-toggle="modal" data-target="#myModalAutoManage" data-id="{{$data_arr->id}}" >
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

