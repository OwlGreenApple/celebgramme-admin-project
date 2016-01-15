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
      <td>
        {{$data_arr->email}}
      </td>
      <td>
        {{$data_arr->fullname}}
      </td>
			
			<!--
      <td align="center" class="total-balance">
        {{$data_arr->balance}}
      </td>
      <td align="center">
        {{$data_arr->valid_until}}
      </td>
      <td align="center">
        <?php if ($data_arr->status_free_trial) {echo"yes";} else {echo"no";} ?>
      </td>
			-->
      <td class="total-auto-manage">
        <?php 
        $t = $data_arr->active_auto_manage;
        $days = floor($t / (60*60*24));
        $hours = floor(($t / (60*60)) % 24);
        $minutes = floor(($t / (60)) % 60);
        $seconds = floor($t  % 60);
        echo $days."D ".$hours."H ".$minutes."M ".$seconds."S";

        ?>
      </td>
      <td>
				{{$data_arr->created_at}}
      </td>
      <td align="center">
        <input type="button" class="btn btn-info btn-daily-like" value="+ likes" data-toggle="modal" data-target="#myModalDailyLikes" data-id="{{$data_arr->id}}" >
        <input type="button" class="btn btn-info btn-auto-manage" value="+ times" data-toggle="modal" data-target="#myModalAutoManage" data-id="{{$data_arr->id}}" >
				<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModalEditMember" data-id="{{$data_arr->id}}" data-email="{{$data_arr->email}}" data-nama="{{$data_arr->fullname}}" >
					<span class='glyphicon glyphicon-pencil'></span> 
				</button>
				<button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$data_arr->id}}" >
					<span class='glyphicon glyphicon-remove'></span> 
				</button>
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

