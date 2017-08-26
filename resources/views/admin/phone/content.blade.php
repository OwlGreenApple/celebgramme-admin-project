<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {

  $i=($page-1)*15 + 1;
  foreach ($data as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$i}}
      </td>
      <td align="center">
			{{$arr->phone}}
      </td>
      <td align="center">
			{{$arr->fullname}}
      </td>
      <td align="center">
			<!--
				<input type="button" class="btn btn-info button-edit-proxy" value="Edit" data-toggle="modal" data-target="#myModal" data-id="{{$arr->id}}" disabled >
				<input type="button" class="btn btn-info button-setting-helper" value="Delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$arr->id}}" disabled>
-->
      </td>
      
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

