<?php 
	use Celebgramme\Models\SettingMeta; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='5' align='center'>Data tidak ada</td></tr>";
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
        {{$data_arr->name}}
      </td>
      <td align="center">
        {{$data_arr->title}}
      </td>
      <td align="center">
        {{$data_arr->message}}
      </td>
      <td align="center">
				<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" data-name="{{$data_arr->name}}" data-title="{{$data_arr->title}}" data-message="{{$data_arr->message}}">
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

