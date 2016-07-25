<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
	use Celebgramme\Models\SettingHelper; 
	use Celebgramme\Models\Proxies; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
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
      <td align="left">
				{{$data_arr->hashtags}}
      </td>
      <td align="left">
				{{$data_arr->username}}
      </td>
      <td align="center">
				{{$data_arr->created}}
      </td>
      <td align="center">
				<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModalUpdateCategories" data-id="{{$data_arr->id}}" data-name="{{$data_arr->name}}" data-hashtags="{{$data_arr->hashtags}}" data-username="{{$data_arr->username}}">
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

