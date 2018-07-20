<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
	// use Celebgramme\Models\SettingHelper; 
	use Celebgramme\Models\Proxies; 
	use Celebgramme\Models\AutoResponderSetting; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
		$server="";$proxy="";$use_automation=""; $server_automation = ""; 
		$identity = ""; $target=""; $number_likes = 0; $is_auto_get_likes = 0; $cookies = "";
		/*$settingHelper = SettingHelper::where("setting_id","=",$data_arr->id)->first();
		if ( !is_null($settingHelper) ) {
			$use_automation = $settingHelper->use_automation;
			$proxies = Proxies::find($settingHelper->proxy_id);
			$server_automation = $settingHelper->server_automation;
			if (!is_null($proxies)) {
				if ($proxies->auth) {
					$proxy = $proxies->proxy.":".$proxies->port.":".$proxies->cred;
				} else {
					$proxy = $proxies->proxy.":".$proxies->port;
				}
			}
			
			$arr1 = explode(";",$settingHelper->identity);
			foreach($arr1 as $arr2) { 
				$identity .= $arr2. " ";
			}
			$arr1 = explode(";",$settingHelper->target);
			foreach($arr1 as $arr2) { 
				$target .= $arr2. ", ";
			}
			
			$number_likes = $settingHelper->number_likes; 
			
			$is_auto_get_likes = $settingHelper->is_auto_get_likes;
			
			$cookies = $settingHelper->cookies;
		}*/
		
		$is_auto_responder = false;
		if (!is_null($data_arr->is_auto_responder)) {
			if ($data_arr->is_auto_responder) {
				$is_auto_responder = true;
			}
		}
		
		$auto_responder_message = "";
		$temps = AutoResponderSetting::where("setting_id",$data_arr->id)->get();
		foreach ($temps as $temp) {
			$auto_responder_message .= $temp->num_of_day."-".$temp->message.";";
		}
		
		/*$user = User::find($data_arr->last_user);
		if (!is_null($user)) {
			if ($user->id == 1267) {
				continue;
			}
		}*/
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
				<?php 
					// if (!is_null($user)) {
						if (!is_null($data_arr->fullname)) { echo $data_arr->fullname;} else {echo"-";}
						echo "(";
						if (!is_null($data_arr->email)) { echo $data_arr->email;} else {echo"-";}
						echo ") / ";
						?><br>
				<input type="button" value="Send email" data-loading-text="Loading..." class="btn btn-primary btn-send-email" data-toggle="modal" data-target="#myModalSendEmail" data-email="{{$data_arr->email}}" data-fullname="{{$data_arr->fullname}}" data-igaccount="{{$data_arr->insta_username}}"> 
				<?php						
					// } else {
						// echo "Email account celebgramme deleted / ";
					// }
				?>
				<br>
        {{$data_arr->insta_username}}/{{$data_arr->insta_password}}/{{$data_arr->start_time}}
      </td>
			<!--
      <td align="center">
				<input type="button" class="btn btn-success btn-check-method-automation" data-toggle="modal" data-target="#myModalEditAutomationMethod" data-id="{{$data_arr->id}}" data-method="{{$data_arr->method}}" value="Change"> 
				
      </td>
			-->
      <td align="center" style="width:350px!important;">
				<a href="#" class="see-all">lihat semua </a>
				<!-- merah =#ea0000   biru = #1212e8  hijau = #15ca26     -->
				<ul style="display:none;" class="data-all" style="width:350px!important;">
					<?php 
					$colorstatus = 000;
					if ($data_arr->status=="started") { $colorstatus="1212e8"; } else if ( ($data_arr->status=="stopped")||($data_arr->status=="deleted")) { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status)}} </span> </strong> </li> 
					<li class="wrap"><strong>Insta username : </strong>{{$data_arr->insta_username}}</li>
					<li class="wrap"><strong>Insta password : </strong>{{$data_arr->insta_password}}</li>
					
					<li class="wrap"><strong>Full auto : </strong><?php if ($data_arr->status_auto) { echo "Full Auto";} else { echo "Manual";} ?></li>

					<?php if ($data_arr->activity_speed=="slow") { $colorstatus="ea0000"; } else if ($data_arr->activity_speed=="normal") { $colorstatus="15ca26"; } else if ($data_arr->activity_speed=="fast") { $colorstatus="1212e8"; } ?>
					<li class="wrap"><strong>Activity speed : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->activity_speed)}} </span> </strong> </li> 
					
					<?php if ($data_arr->status_auto) { ?>
					<li class="wrap"><strong>Identity Categories : </strong><?php //echo $identity ?></li>
					<li class="wrap"><strong>Target Categories : </strong><?php //echo $target ?></li>
					<?php } ?>
					
					
					<li class="wrap"><strong>is Auto Likes : </strong><?php //if ($is_auto_get_likes) { echo "Yes"; } else { echo "No";} ?></li>
					<li class="wrap"><strong>Number Likes : </strong><?php //echo $number_likes; ?></li>
					<li class="wrap"><strong>is Auto Responder : </strong><?php if ($is_auto_responder) { echo "Yes"; } else { echo "No";} ?></li>
					<li class="wrap"><strong>Welcome Message : </strong><?php  echo $data_arr->messages;  ?></li>
					<li class="wrap"><strong>Auto Responder Message : </strong><?php  echo $auto_responder_message; ?></li>
					<?php if (!$data_arr->status_auto) { ?>
					<?php if ($data_arr->status_follow_unfollow=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_follow_unfollow=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Follow  : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_follow_unfollow)}} </span> </strong> </li> 
					<?php if ($data_arr->status_like=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_like=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Like : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_like)}} </span> </strong> </li> 
					<?php if ($data_arr->status_comment=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_comment=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Comment : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_comment)}} </span> </strong> </li> 
					
					<?php if ($data_arr->activity=="follow") { $colorstatus="1212e8"; } else if ($data_arr->activity=="unfollow") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Activity : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->activity)}} </span> </strong> </li> 
					<?php if ($data_arr->follow_source=="hashtags") { $colorstatus="1212e8"; } else if ($data_arr->follow_source=="username") { $colorstatus="ea0000"; }  ?>
					<li class="wrap"><strong>Follow source : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->follow_source)}} </span> </strong> </li> 
					<li class="wrap"><strong>Comments : </strong>{{$data_arr->comments}}</li>
					<li class="wrap"><strong>Hashtags : </strong>{{str_replace("#","",$data_arr->hashtags)}}</li>
					<li class="wrap"><strong>Username : </strong>{{$data_arr->username}}</li>
					<li class="wrap"><strong>Media age : </strong>{{$data_arr->media_age}}</li>
					<li class="wrap"><strong>Media type : </strong>{{$data_arr->media_type}}</li>
					<!--<li class="wrap"><strong>Follow source : </strong>{{$data_arr->follow_source}}</li>-->
					<li class="wrap"><strong>Dont follow same user : </strong>{{$data_arr->dont_follow_su}}</li>
					<li class="wrap"><strong>Dont follow private user : </strong>{{$data_arr->dont_follow_pu}}</li>
					<!--<li class="wrap"><strong>Unfollow source : </strong>{{$data_arr->unfollow_source}}</li>
					<li class="wrap"><strong>Unfollow who dont follow me : </strong>{{$data_arr->unfollow_wdfm}}</li>-->
					<?php } ?>
					<li class="wrap"><strong>usernames whitelist : </strong>{{$data_arr->usernames_whitelist}}</li>
					<li class="wrap"><strong>usernames blacklist : </strong>{{$data_arr->usernames_blacklist}}</li>
					<li class="wrap"><strong>Follow Sunday : </strong><?php if ($data_arr->is_sunday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Monday : </strong><?php if ($data_arr->is_monday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Tuesday : </strong><?php if ($data_arr->is_tuesday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Wednesday : </strong><?php if ($data_arr->is_wednesday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Thursday : </strong><?php if ($data_arr->is_thursday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Friday : </strong><?php if ($data_arr->is_friday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Follow Saturday : </strong><?php if ($data_arr->is_saturday_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
					
					<li class="wrap"><strong>Like Sunday : </strong><?php if ($data_arr->is_sunday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Monday : </strong><?php if ($data_arr->is_monday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Tuesday : </strong><?php if ($data_arr->is_tuesday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Wednesday : </strong><?php if ($data_arr->is_wednesday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Thursday : </strong><?php if ($data_arr->is_thursday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Friday : </strong><?php if ($data_arr->is_friday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					<li class="wrap"><strong>Like Saturday : </strong><?php if ($data_arr->is_saturday_like) { echo "ON"; } else { echo "OFF"; } ?></li>
					
					<li class="wrap"><strong>Max Follow : </strong>{{$data_arr->max_follow}}</li>
					<li class="wrap"><strong>Auto Switch Follow-Unfollow : </strong><?php if ($data_arr->is_auto_follow) { echo "ON"; } else { echo "OFF"; } ?></li>
				</ul>
      </td>
<!--
      <td align="center">
				Hashtags
				<select>
					<option data-val="Users Who Tagged (Only Follow)">Follow # Hashtags (Only Follow)</option>
					<option data-val="Relevant">Like Comment # Relevant</option>
				</select>
        <span class="glyphicon glyphicon-save download-hashtags" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
				<br><br>
				
				Usernames
				<select class="select-username">
					<option>User's Follower</option>
				</select>
        <span class="glyphicon glyphicon-save download-usernames" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
				<br><br>
				
				Comment
        <span class="glyphicon glyphicon-save download-comments" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
      </td>
			-->
      <td align="center" class="setting-proxy">
				<input type="button" class="btn btn-info button-setting-proxy" value="Assign" data-toggle="modal" data-target="#myModalAutomation" data-id="{{$data_arr->id}}">
			</td>
      <td align="center">
				<p class="server-automation-name">
				<span class="edit-server-automation">
				<?php 
					// echo $server_automation;
				?>
				<input type="button" class="btn btn-info button-show-server_automation" value="Show Server Automation" data-id="{{$data_arr->id}}">
				
				</span>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-server-automation-edit" data-toggle="modal" data-target="#serverAutomationModal" data-id="{{$data_arr->id}}"
				data-filename="{{$server_automation}}" style="cursor:pointer;">  </span>
				/

        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-setting" data-header="Server Automation" data-id="{{$data_arr->id}}" data-action="server_liker"> Show </button>
				<!--<?php 
					if ($is_auto_get_likes) { 
						echo SettingMeta::getMeta($data_arr->id,"server_liker");
					} 
					else { 
						echo "-";
					} 
				?>-->
				
				</p>
			</td>
      <td align="center">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-setting" data-header="Followers" data-id="{{$data_arr->id}}" data-action="followers"> Show </button>
        <!--<?php 
					$followers = SettingMeta::getMeta($data_arr->id,"followers");
					echo number_format($followers,0,'','.');
				?>-->
			</td>
      <td align="center">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-setting" data-header="Following" data-id="{{$data_arr->id}}" data-action="following"> Show </button>
        <!--<?php 
					$following = SettingMeta::getMeta($data_arr->id,"following");
					echo number_format($following,0,'','.');
				?>-->
			</td>
      <td align="center">
				<input type="button" class="btn btn-info button-show-cookies" value="Show" data-id="{{$data_arr->id}}">
				<?php 
					/*if ($cookies=="error login status :check") {
						echo "Error Password Reset";
					} else
					if ($cookies=="success") {
						echo "OK";
					} else
					if ($cookies=="error csrf status : new") {
						echo "Error Konfirmasi Telepon / Email";
					} else
					if ($cookies=="") {
						echo "OFF";
					} else {
						echo $cookies;
					}*/
				?>
			</td>
      <td align="center">
				<input type="button" value="Open" data-loading-text="Loading..." class="btn btn-primary btn-show-log" data-toggle="modal" data-target="#myModalLog" data-id="{{$data_arr->id}}"> 
				<input type="button" value="Setting Logs" data-loading-text="Loading..." class="btn btn-primary btn-show-log-settings" data-toggle="modal" data-target="#myModalSettingLogs" data-id="{{$data_arr->id}}"> 
				<input type="button" value="Daily" data-loading-text="Loading..." class="btn btn-primary btn-show-log-daily" data-toggle="modal" data-target="#myModalDaily" data-id="{{$data_arr->id}}"> 
				<input type="button" value="Hourly" data-loading-text="Loading..." class="btn btn-primary btn-show-log-hourly" data-toggle="modal" data-target="#myModalHourly" data-id="{{$data_arr->id}}"> 
				<input type="button" value="Refresh" data-loading-text="Loading..." class="btn btn-primary btn-refresh-account"  data-id="{{$data_arr->id}}"> 
				<input type="button" value="Refresh Auth" data-loading-text="Loading..." class="btn btn-primary btn-refresh-auth"  data-id="{{$data_arr->id}}"> 
				<?php 
				if ($data_arr->status=="stopped") {
				?>
				<input type="button" value="Start" data-loading-text="Loading..." class="btn btn-primary btn-start"  data-id="{{$data_arr->id}}"> 
				<?php } ?>
				<?php if ($admin->email == "celebgramme.dev@gmail.com") { ?>
				<input type="button" value="Delete Session" data-loading-text="Loading..." class="btn btn-primary btn-delete-session"  data-id="{{$data_arr->id}}"> 
				<?php } ?>
			</td>
			<!--
      <td align="center">
				<input type="button" class="btn btn-primary button-method" data-id="{{$data_arr->id}}" value="Automation" data-toggle="modal" data-target="#myModalMethodAutomation" 
				<?php 
				// if ($use_automation) {echo "data-automation='yes'";} else { echo "data-automation='no'"; } 
				?>>
			</td>
      <td align="center">
				<?php //if ( ($admin->email == "celebgramme.dev@gmail.com") || ($admin->email == "admin@admin.com") ) { ?>
				<input type="button" class="btn btn-warning btn-delete-proxy" value="Clear" data-toggle="modal" data-target="#confirm-delete" data-id="{{$data_arr->id}}">

				<?php //} ?>
      </td>
			-->
<!-- glyphicon glyphicon-hand-right manual glyphicon-wrench auto -->
			
			
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

