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
      <td align="center">
				{{$data_arr->max_account}}
      </td>
      <td>
				{{$data_arr->created_at}}
      </td>
      <td align="center">
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

