<?php 
	use Celebgramme\Models\Setting;
	use Celebgramme\Models\SettingMeta; 
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
					?>
					<li> {{$string}} </li>
					<?php } ?>
				</ul>
				<?php  
					$setting = Setting::find($data_arr->setting_id);
				?>
				<ul style="display:none;" class="data-all">
					<li><strong>Insta username : </strong>{{$setting->insta_username}}</li>
					<li><strong>Insta password : </strong>{{$setting->insta_password}}</li>
					<li><strong>Activity : </strong>{{$setting->activity}}</li>
					<li><strong>Activity speed : </strong>{{$setting->activity_speed}}</li>
					<li><strong>Comments : </strong>{{$setting->comments}}</li>
					<li><strong>Tags : </strong>{{$setting->tags}}</li>
					<li><strong>Username : </strong>{{$setting->username}}</li>
					<li><strong>Media source : </strong>{{$setting->media_source}}</li>
					<li><strong>Media age : </strong>{{$setting->media_age}}</li>
					<li><strong>Media type : </strong>{{$setting->media_type}}</li>
					<li><strong>Min likes media : </strong>{{$setting->min_likes_media}}</li>
					<li><strong>Max likes media : </strong>{{$setting->max_likes_media}}</li>
					<li><strong>Dont comment same user : </strong>{{$setting->dont_comment_su}}</li>
					<li><strong>Follow source : </strong>{{$setting->follow_source}}</li>
					<li><strong>Dont follow same user : </strong>{{$setting->dont_follow_su}}</li>
					<li><strong>Dont follow private user : </strong>{{$setting->dont_follow_pu}}</li>
					<li><strong>Unfollow source : </strong>{{$setting->unfollow_source}}</li>
					<li><strong>Unfollow who dont follow me : </strong>{{$setting->unfollow_wdfm}}</li>
					<li><strong>Unfollow who usernames whitelist : </strong>{{$setting->usernames_whitelist}}</li>
					<li><strong>Status : </strong>{{$setting->status}}</li>
				</ul>
      </td>
      <td align="center" style="width:100px;">
        {{$data_arr->updated_at}}
      </td>
      <td align="center">
        <span class="glyphicon glyphicon-save download-all" style="cursor:pointer;"></span>
      </td>
      <td align="center">
				<select>
					<option>Relevant</option>
					<option>User's Photo</option>
				</select>
        <span class="glyphicon glyphicon-save download-hashtags" style="cursor:pointer;" data-id="{{$data_arr->setting_id}}"></span>
      </td>
      <td align="center">
				<select>
					<option>Normal Search</option>
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

