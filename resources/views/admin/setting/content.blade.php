<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
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
        {{$data_arr->insta_username}}
      </td>
      <td align="center">
        {{$data_arr->insta_password}}
      </td>
      <td align="center">
				<?php 
					$user = User::find($data_arr->last_user);
					if (!is_null($user)) {
						echo $user->fullname."(".$user->email.")";?><br>
				<input type="button" value="Send email" data-loading-text="Loading..." class="btn btn-primary btn-send-email" data-toggle="modal" data-target="#myModalSendEmail" data-email="{{$user->email}}" data-fullname="{{$user->fullname}}" data-igaccount="{{$data_arr->insta_username}}"> 
				<?php						
					} else {
						echo "Email account celebgramme deleted";
					}
				?><br>
      </td>
      <td align="center">
				<p class="fl-filename">
				<span class="edit-fl-filename">
				<?php 
					$filename = "";
					if (SettingMeta::getMeta($data_arr->id,"fl_filename") <> "0" ) {
						$filename = SettingMeta::getMeta($data_arr->id,"fl_filename");
						echo $filename."";
					}
				?>
				</span>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-fl-edit" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}"
				data-filename="{{$filename}}" style="cursor:pointer;">  </span>
				</p>
      </td>
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
					
					<?php if ($data_arr->status_follow_unfollow=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_follow_unfollow=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Follow  : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_follow_unfollow)}} </span> </strong> </li> 
					<?php if ($data_arr->status_like=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_like=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Like : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_like)}} </span> </strong> </li> 
					<?php if ($data_arr->status_comment=="on") { $colorstatus="1212e8"; } else if ($data_arr->status_comment=="off") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Status Comment : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->status_comment)}} </span> </strong> </li> 
					
					<?php if ($data_arr->activity=="follow") { $colorstatus="1212e8"; } else if ($data_arr->activity=="unfollow") { $colorstatus="ea0000"; } ?>
					<li class="wrap"><strong>Activity : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->activity)}} </span> </strong> </li> 
					<?php if ($data_arr->activity_speed=="slow") { $colorstatus="ea0000"; } else if ($data_arr->activity_speed=="normal") { $colorstatus="15ca26"; } else if ($data_arr->activity_speed=="fast") { $colorstatus="1212e8"; } ?>
					<li class="wrap"><strong>Activity speed : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->activity_speed)}} </span> </strong> </li> 
					<?php if ($data_arr->follow_source=="hashtags") { $colorstatus="1212e8"; } else if ($data_arr->follow_source=="username") { $colorstatus="ea0000"; }  ?>
					<li class="wrap"><strong>Follow source : <span style="color:#{{$colorstatus}}"> {{strtoupper($data_arr->follow_source)}} </span> </strong> </li> 
					<li class="wrap"><strong>Comments : </strong>{{$data_arr->comments}}</li>
					<li class="wrap"><strong>Hashtags : </strong>{{str_replace("#","",$data_arr->hashtags)}}</li>
					<li class="wrap"><strong>Username : </strong>{{$data_arr->username}}</li>
					<li class="wrap"><strong>Media age : </strong>{{$data_arr->media_age}}</li>
					<li class="wrap"><strong>Media type : </strong>{{$data_arr->media_type}}</li>
					<li class="wrap"><strong>Min likes media : </strong>{{$data_arr->min_likes_media}}</li>
					<li class="wrap"><strong>Max likes media : </strong>{{$data_arr->max_likes_media}}</li>
					<li class="wrap"><strong>Dont comment same user : </strong>{{$data_arr->dont_comment_su}}</li>
					<!--<li class="wrap"><strong>Follow source : </strong>{{$data_arr->follow_source}}</li>-->
					<li class="wrap"><strong>Dont follow same user : </strong>{{$data_arr->dont_follow_su}}</li>
					<li class="wrap"><strong>Dont follow private user : </strong>{{$data_arr->dont_follow_pu}}</li>
					<!--<li class="wrap"><strong>Unfollow source : </strong>{{$data_arr->unfollow_source}}</li>
					<li class="wrap"><strong>Unfollow who dont follow me : </strong>{{$data_arr->unfollow_wdfm}}</li>-->
					<li class="wrap"><strong>usernames whitelist : </strong>{{$data_arr->usernames_whitelist}}</li>
				</ul>
      </td>

      <td align="center">
				<select>
					<option data-val="Relevant">Like Comment # Relevant</option>
					<option data-val="Normal Search">Follow # Normal Search</option>
				</select>
        <span class="glyphicon glyphicon-save download-hashtags" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
      </td>
      <td align="center">
				<select>
					<option>User's Follower</option>
					<option>User's Photo</option>
					<option>User's Following</option>
				</select>
        <span class="glyphicon glyphicon-save download-usernames" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
      </td>
      <td align="center">
        <span class="glyphicon glyphicon-save download-comments" style="cursor:pointer;" data-id="{{$data_arr->id}}"></span>
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

