<?php 
	use Celebgramme\Models\Setting;
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr class="row{{$data_arr->setting_id}}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$data_arr->insta_username}}
      </td>
      <td align="center">
        {{$data_arr->insta_password}}
      </td>
      <td align="center">
				<?php 
					$user = User::find($data_arr->last_user);
				?>
        {{$user->fullname."(".$user->email.")"}}
      </td>
      <td align="center">
				<p class="fl-filename">
				<span class="edit-fl-filename">
				<?php 
					$filename = "";
					if (SettingMeta::getMeta($data_arr->setting_id,"fl_filename") <> "0" ) {
						$filename = SettingMeta::getMeta($data_arr->setting_id,"fl_filename");
						echo $filename."";
					}
				?>
				</span>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-fl-edit" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->setting_id}}"
				data-filename="{{$filename}}" style="cursor:pointer;">  </span>
				</p>
      </td>
      <td align="center">
        <?php if ($data_arr->error_cred) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-error" data-id="{{$data_arr->setting_id}}"></i>
        <?php } ?>
      </td>
      <td align="center" style="width:350px!important;">
				<a href="#" class="see-update">lihat updates </a> |
				<a href="#" class="see-all">lihat semua </a>
				<ul style="display:none;" class="data-updates"> 
					<?php 
					$strings =  explode("~", substr($data_arr->description,12));
					foreach ($strings as $string){
							$pieces = explode("=", $string );	
							if (count($pieces)>1) {
					?>
					<li class="wrap"> 
						<?php 
									$colorstatus="";
									// echo "<span>".$pieces[0]."</span>";
									if ($pieces[0]==" status ") {
										if ($pieces[1]==" started "){ $colorstatus="1212e8"; } else if ( ($pieces[1]==" stopped ") || ($pieces[1]==" deleted ") ) { $colorstatus="ea0000"; }
									}
									if ($colorstatus=="") {
										echo "<strong>".$pieces[0].": </strong> ".$pieces[1];
									} else {
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
							 
							// echo $string;
						?>
					</li>
					<?php } }?>
				</ul>
				<?php  
					$setting = Setting::find($data_arr->setting_id);
					$colorstatus = 000;
				?> 
				<!-- merah =#ea0000   biru = #1212e8  hijau = #15ca26     -->
				<ul style="display:none;" class="data-all" style="width:350px!important;">
					<?php if ($setting->status=="started") { $colorstatus="1212e8"; } else if ( ($setting->status=="stopped") || ($setting->status=="deleted") ){ $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status)}} </span> </strong> </li> 
					<li class="wrap"><strong>Insta username : </strong>{{$setting->insta_username}}</li>
					<li class="wrap"><strong>Insta password : </strong>{{$setting->insta_password}}</li>
					
					<?php if ($setting->status_follow_unfollow=="on") { $colorstatus="1212e8"; } else if ($setting->status_follow_unfollow=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Follow  : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status_follow_unfollow)}} </span> </strong> </li> 
					<?php if ($setting->status_like=="on") { $colorstatus="1212e8"; } else if ($setting->status_like=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Like : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status_like)}} </span> </strong> </li> 
					<?php if ($setting->status_comment=="on") { $colorstatus="1212e8"; } else if ($setting->status_comment=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Comment : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status_comment)}} </span> </strong> </li> 
					
					<?php if ($setting->activity=="follow") { $colorstatus="1212e8"; } else if ($setting->activity=="unfollow") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Activity : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->activity)}} </span> </strong> </li> 
					<?php if ($setting->activity_speed=="slow") { $colorstatus="ea0000"; } else if ($setting->activity_speed=="normal") { $colorstatus="15ca26"; } else if ($setting->activity_speed=="fast") { $colorstatus="1212e8"; } ?>
					<li class="wrap"><strong>Activity speed : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->activity_speed)}} </span> </strong> </li> 
					<li class="wrap"><strong>Media source : </strong>{{$setting->media_source}}</li>
					<li class="wrap"><strong>Comments : </strong>{{$setting->comments}}</li>
					<li class="wrap"><strong>Hashtags : </strong>{{$setting->hashtags}}</li>
					<li class="wrap"><strong>Username : </strong>{{$setting->username}}</li>
					<li class="wrap"><strong>Media age : </strong>{{$setting->media_age}}</li>
					<li class="wrap"><strong>Media type : </strong>{{$setting->media_type}}</li>
					<li class="wrap"><strong>Min likes media : </strong>{{$setting->min_likes_media}}</li>
					<li class="wrap"><strong>Max likes media : </strong>{{$setting->max_likes_media}}</li>
					<li class="wrap"><strong>Dont comment same user : </strong>{{$setting->dont_comment_su}}</li>
					<li class="wrap"><strong>Follow source : </strong>{{$setting->follow_source}}</li>
					<li class="wrap"><strong>Dont follow same user : </strong>{{$setting->dont_follow_su}}</li>
					<li class="wrap"><strong>Dont follow private user : </strong>{{$setting->dont_follow_pu}}</li>
					<li class="wrap"><strong>Unfollow source : </strong>{{$setting->unfollow_source}}</li>
					<li class="wrap"><strong>Unfollow who dont follow me : </strong>{{$setting->unfollow_wdfm}}</li>
					<li class="wrap"><strong>Unfollow who usernames whitelist : </strong>{{$setting->usernames_whitelist}}</li>
				</ul>
      </td>
      <td align="center" style="width:100px;">
        {{$data_arr->updated_at}}
      </td>
      <td align="center">
        <span class="glyphicon glyphicon-save download-all" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
      <td align="center">
				<select>
					<option>Relevant</option>
					<option>Normal Search</option>
				</select>
        <span class="glyphicon glyphicon-save download-hashtags" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
      <td align="center">
				<select>
					<option>User's Photo</option>
					<option>User's Follower</option>
					<option>User's Following</option>
				</select>
        <span class="glyphicon glyphicon-save download-usernames" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
      <td align="center">
        <span class="glyphicon glyphicon-save download-comments" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
      <td align="center">
        <?php if ($data_arr->type=="success") { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-status" data-id="{{$data_arr->id}}"></i>
        <?php } ?>
      </td>
      <td align="center">
        <?php if ($data_arr->status_admin==0) { ?>
          <i class="x-icon update-status-admin" data-id="{{$data_arr->id}}"></i>
        <?php } else { ?>
          Taken by admin : 
        <?php 
					$admin = User::find($data_arr->status_admin);
					echo $admin->fullname;
				} ?>
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

