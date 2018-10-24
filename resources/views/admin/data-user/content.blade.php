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
      <td>
        {{$data_arr->created_at}}
      </td>
      <td>
        <?php echo floor($data_arr->active_auto_manage/86400) ?> 
      </td>
      <td>
        <?php echo floor($data_arr->active_time/86400) ?> 
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

