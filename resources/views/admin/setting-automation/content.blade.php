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
        <?php if ($data_arr->error_cred) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-error" data-id="{{$data_arr->id}}"></i>
        <?php } ?>
      </td>
      <td align="center">
        {{$data_arr->insta_username." / "}} 
				<?php 
					$user = User::find($data_arr->last_user);
					if (!is_null($user)) {
						echo $user->fullname."(".$user->email.") / ";?>
				<?php						
					} else {
						echo "Email account celebgramme deleted / ";
					}
				?>
				{{$data_arr->start_time}}
      </td>
      <td align="center">
				<p class="identity">
				<span class="edit-identity">
				<?php 
					if ($data_arr->identity == "") { echo "-"; } 
					else {
						echo $data_arr->identity;
					}
				?>
				</span>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-identity-edit" data-toggle="modal" data-target="#myModalIdentity" data-id="{{$data_arr->setting_id}}"
				data-filename="{{$data_arr->identity}}" style="cursor:pointer;">  </span>
				</p>
      </td>
      <td align="center">
				<p class="target">
				<span class="edit-target">
				<?php 
					if ($data_arr->target == "") { echo "-"; } 
					else {
						echo $data_arr->target;
					}
				?>
				</span>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-target-edit" data-toggle="modal" data-target="#myModalTarget" data-id="{{$data_arr->setting_id}}"
				data-filename="{{$data_arr->target}}" style="cursor:pointer;">  </span>
				</p>
      </td>
      <td align="center">
        <?php 
					$followers = SettingMeta::getMeta($data_arr->setting_id,"followers");
					echo number_format($followers,0,'','.');
				?>
      </td>
      <td align="center">
        <?php 
					$following = SettingMeta::getMeta($data_arr->setting_id,"following");
					echo number_format($following,0,'','.');
				?>
      </td>
      <td align="center">
			<?php 
				$proxy = Proxies::find($data_arr->proxy_id);
				if (!is_null($proxy)) {
					if ($proxy->auth) {
						echo $proxy->proxy.":".$proxy->port.":".$proxy->cred;
					} else if (!$proxy->auth) {
						echo $proxy->proxy.":".$proxy->port;
					}
				}
				?>
      </td>
      <td align="center">
				<?php 
					if ($data_arr->cookies=="error login status :check") {
						echo "Error Password Reset";
					} else
					if ($data_arr->cookies=="success") {
						echo "OK";
					} else
					if ($data_arr->cookies=="error csrf status : new") {
						echo "Error Konfirmasi Telepon / Email";
					} else
					if ($data_arr->cookies=="") {
						echo "OFF";
					} else {
						echo $data_arr->cookies;
					}
				?>
      </td>
      <td align="center">
				<input type="button" value="Open" data-loading-text="Loading..." class="btn btn-primary btn-show-log" data-toggle="modal" data-target="#myModalLog" data-id="{{$data_arr->setting_id}}"> 
				<input type="button" value="Daily" data-loading-text="Loading..." class="btn btn-primary btn-show-log-daily" data-toggle="modal" data-target="#myModalDaily" data-id="{{$data_arr->setting_id}}"> 
				<input type="button" value="Hourly" data-loading-text="Loading..." class="btn btn-primary btn-show-log-hourly" data-toggle="modal" data-target="#myModalHourly" data-id="{{$data_arr->setting_id}}"> 
				<input type="button" value="Refresh" data-loading-text="Loading..." class="btn btn-primary btn-refresh-account"  data-id="{{$data_arr->setting_id}}"> 
				<input type="button" value="Refresh Auth" data-loading-text="Loading..." class="btn btn-primary btn-refresh-auth"  data-id="{{$data_arr->setting_id}}"> 
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

