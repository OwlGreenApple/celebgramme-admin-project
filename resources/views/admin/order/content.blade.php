<?php 
  use Celebgramme\Models\Package;
  use Celebgramme\Models\User;
  use Celebgramme\Models\OrderMeta;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
			$email = ""; $fullname = "";
			$user = User::find($data_arr->user_id);	
			if (!is_null($user)) {
				$email = $user->email; 
				$fullname = $user->fullname;
			}
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
      <td>
        {{$email}}
      </td>
      <td>
        {{$fullname}}
      </td>
      <td align="right">
        {{number_format($data_arr->total-$data_arr->discount,0,'','.')}}
      </td>
      <td>
        <?php 
					if ($data_arr->type == "daily-activity") {
						$package = Package::find($data_arr->package_manage_id);
						if (!is_null($package)) { echo $package->package_name."</span>";} else { echo "-";}
					}
					else if ($data_arr->type == "max-account") {
						echo $data_arr->added_account." Akun";
					}
        ?>
      </td>
      <td> <!-- keterangan -->
			<?php 
				if ($data_arr->order_status == "pending") { echo "<span style='color:#c12e2a;font-weight:Bold;'>Pending order</span>";}
				else { echo "<span style='color:#1e80e1;font-weight:Bold;'>".$data_arr->order_status."</span>"; }
				echo "<br>";
				echo OrderMeta::getMeta($data_arr->id,"logs");
			?>
      </td>
      <td align="center">
				<?php if ( ($admin->email == "celebgramme.dev@gmail.com") || ($admin->email == "admin@admin.com") ) { ?>
				<button type="button" class="btn btn-warning btn-update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" data-total="{{$data_arr->total}}" data-affiliate="{{$data_arr->affiliate}}" data-package-manage-id="{{$data_arr->package_manage_id}}" data-email="{{$email}}" data-fullname="{{$fullname}}">
					<span class='glyphicon glyphicon-pencil'></span> 
				</button>
				<button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$data_arr->id}}" <?php if ( ($data_arr->order_status == "success") || ($data_arr->order_status == "cron dari affiliate") ) { echo "disabled"; } ?>>
					<span class='glyphicon glyphicon-remove'></span> 
				</button>
				<?php } ?>
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

