<?php 
	use Celebgramme\Models\SettingMeta; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='3' align='center'>Data tidak ada</td></tr>";
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
        {{$data_arr->meta_value}}
      </td>
      <td align="center">
				<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" data-value="{{$data_arr->meta_value}}" data-color="{{$data_arr->other_const}}">
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

