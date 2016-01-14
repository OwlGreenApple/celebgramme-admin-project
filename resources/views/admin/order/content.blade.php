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
        {{$data_arr->created_at}}
      </td>
      <td>
        {{$data_arr->no_order}}
      </td>
      <td align="right">
        {{number_format($data_arr->total,0,'','.')}}
      </td>
      <td>
        <?php 
          $package = Package::find($data_arr->package_manage_id);
          if (!is_null($package)) { echo $package->package_name;} else { echo "-";}
        ?>
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
				<button type="button" class="btn btn-warning btn-auto-manage" data-toggle="modal" data-target="#myModalAutoManage" data-id="{{$data_arr->id}}">
					<span class='glyphicon glyphicon-pencil'></span> 
				</button>
				<button type="button" class="btn btn-danger btn-auto-manage" data-toggle="modal" data-target="#myModalAutoManage" data-id="{{$data_arr->id}}" >
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

