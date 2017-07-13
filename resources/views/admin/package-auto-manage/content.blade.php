<?php 
  use Celebgramme\Models\Package;
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
        {{$data_arr->package_name}}
      </td>
      <td align="right">
        {{number_format($data_arr->price,0,'','.')}}
      </td>
      <td>
				{{$data_arr->active_days}}
      </td>
      <td>
				{{$data_arr->max_account}}
      </td>
      <td>
				<?php 
				  if($data_arr->affiliate) {
						echo "Yes";
					}else {
						echo "No";
					}
				?>
      </td>
      <td align="center">
	<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" data-package-name="{{$data_arr->package_name}}" data-price="{{$data_arr->price}}" data-active-days="{{$data_arr->active_days}}" data-affiliate="{{$data_arr->affiliate}}" data-max_account="{{$data_arr->max_account}}">
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

