<?php 
	use Celebgramme\Models\Setting;
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
	use Celebgramme\Models\UserMeta;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='14' align='center'>Data tidak ada</td></tr>";
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
        <?php if ($data_arr->status_admin==0) { ?>
          <i class="x-icon update-status-admin" data-id="{{$data_arr->id}}"></i>
        <?php } else { ?>
          Taken by admin : 
        <?php 
					$admin = User::find($data_arr->status_admin);
					$color = UserMeta::getMeta($admin->id,"color");
					echo "<strong><span style='color:".$color."'>".$admin->fullname."</span></strong>";
				} ?>
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
          <i class="x-icon update-error" data-toggle="modal" data-target="#confirm-dialog" data-id="{{$data_arr->setting_id}}"></i>
        <?php } ?>
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
					if (!is_null($user)) {
						echo $user->fullname."(".$user->email.")";?>
				<input type="button" value="Send email" data-loading-text="Loading..." class="btn btn-primary btn-send-email" data-toggle="modal" data-target="#myModalSendEmail" data-email="{{$user->email}}" data-fullname="{{$user->fullname}}" data-igaccount="{{$data_arr->insta_username}}" data-settingid="{{$data_arr->setting_id}}"> 
				<?php						
					} else {
						echo "Email account celebgramme deleted";
					}
				?><br>
      </td>
      <td align="center" style="width:350px!important;">
				<a href="#" class="see-update">lihat updates </a> |
				<a href="#" class="see-all">lihat semua </a>
				<?php  
					$setting = Setting::find($data_arr->setting_id);
					$colorstatus = 000;
				?> 
				<ul style="display:none;" class="data-updates"> 
					<?php //if ($setting->status=="started") { $colorstatus="1212e8"; } else if ( ($setting->status=="stopped") || ($setting->status=="deleted") ){ $colorstatus="ea0000"; } ?>
					<!--<li class="wrap"><strong>Status : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status)}} </span> </strong> </li> -->
					<?php 
					$strings =  explode("~", substr($data_arr->description,12));
					foreach ($strings as $string){
							$pieces = explode("=", $string );	
							if (count($pieces)>1) {
					?>
					<li class="wrap"> 
						<?php 

								if ($pieces[0]==" status_follow_unfollow ") {
									if ($pieces[1]==" on "){ $str= "<span style='color:#1212e8'> ON - ".strtoupper($setting->activity);	} 
									else if ($pieces[1]==" off "){ $str= "<span style='color:#ea0000'> OFF ";	} 
									echo "<strong>Activity: ".$str."</strong> ";
								} 
									else if ($pieces[0]==" status ") {
										$colorstatus="";
										if ($pieces[1]==" started "){ $colorstatus="1212e8"; } else if ( ($pieces[1]==" stopped ") || ($pieces[1]==" deleted ") ) { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" status_like ") {
										$colorstatus="";
										if ($pieces[1]==" on "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" off ") { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}

									else if ($pieces[0]==" status_comment ") {
										$colorstatus="";
										if ($pieces[1]==" on "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" off ") { $colorstatus="ea0000"; }
										echo "<strong>".$pieces[0].": <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" follow_source ") {
										$colorstatus="";
										if ($pieces[1]==" hashtags "){ $colorstatus="1212e8"; } else if  ($pieces[1]==" username ") { $colorstatus="ea0000"; }
										echo "<strong>Follow Source: <span style='color:#".$colorstatus."'> ".strtoupper($pieces[1])."</span></strong> ";
									}
									
									else if ($pieces[0]==" hashtags ") {
										echo "<strong>Follow Source: </strong>".str_replace("#","",$pieces[1]);
									}
									
								else {
									echo "<strong>".$pieces[0].": </strong> ".$pieces[1];
								}
						
							 
							// echo $string;
						?>
					</li>
					<?php } }?>
				</ul>
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
					<li class="wrap"><strong>Activity : <span style="color:#{{$colorstatus}}"> 
						<?php 
							if ($setting->status_follow_unfollow=="on") {
								echo "<span style='color:#1212e8'> ON - ".strtoupper($setting->activity); 
							}else if ($setting->status_follow_unfollow=="off") { 
								$colorstatus="ea0000";
							?>
								<span style="color:#{{$colorstatus}}"> {{strtoupper($setting->status_follow_unfollow)}} </span>
							<?php }
						?>						
					</span> </strong> </li> 
					<?php if ($setting->activity_speed=="slow") { $colorstatus="ea0000"; } else if ($setting->activity_speed=="normal") { $colorstatus="15ca26"; } else if ($setting->activity_speed=="fast") { $colorstatus="1212e8"; } ?>
					<li class="wrap"><strong>Activity speed : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->activity_speed)}} </span> </strong> </li> 
					<?php if ($setting->follow_source=="hashtags") { $colorstatus="1212e8"; } else if ($setting->follow_source=="username") { $colorstatus="ea0000"; }  ?>
					<li class="wrap"><strong>Follow source : <span style="color:#{{$colorstatus}}"> {{strtoupper($setting->follow_source)}} </span> </strong> </li> 
					<li class="wrap"><strong>Comments : </strong>{{$setting->comments}}</li>
					<li class="wrap"><strong>Hashtags : </strong>{{str_replace("#","",$setting->hashtags);}}</li>
					<li class="wrap"><strong>Username : </strong>{{$setting->username}}</li>
					<li class="wrap"><strong>Media age : </strong>{{$setting->media_age}}</li>
					<li class="wrap"><strong>Media type : </strong>{{$setting->media_type}}</li>
					<li class="wrap"><strong>Min likes media : </strong>{{$setting->min_likes_media}}</li>
					<li class="wrap"><strong>Max likes media : </strong>{{$setting->max_likes_media}}</li>
					<li class="wrap"><strong>Dont comment same user : </strong>{{$setting->dont_comment_su}}</li>
					<!--<li class="wrap"><strong>Follow source : </strong>{{$setting->follow_source}}</li>-->
					<li class="wrap"><strong>Dont follow same user : </strong>{{$setting->dont_follow_su}}</li>
					<li class="wrap"><strong>Dont follow private user : </strong>{{$setting->dont_follow_pu}}</li>
					<!--<li class="wrap"><strong>Unfollow source : </strong>{{$setting->unfollow_source}}</li>
					<li class="wrap"><strong>Unfollow who dont follow me : </strong>{{$setting->unfollow_wdfm}}</li>-->
					<li class="wrap"><strong>Usernames whitelist : </strong>{{$setting->usernames_whitelist}}</li>
				</ul>
      </td>
      <td align="center" style="width:100px;">
        {{$data_arr->updated_at}}
      </td><!--
      <td align="center">
        <span class="glyphicon glyphicon-save download-all" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
			-->
      <td align="center">
				<select>
					<option data-val="Normal Search">Follow # Normal Search</option>
					<option data-val="Relevant">Like Comment # Relevant</option>
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
          <i class="x-icon update-status" data-toggle="modal" data-target="#confirm-dialog" data-id="{{$data_arr->id}}"></i>
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
		$("#update-post").html("<?php echo $postUpdate; ?>");
  });

</script>		

