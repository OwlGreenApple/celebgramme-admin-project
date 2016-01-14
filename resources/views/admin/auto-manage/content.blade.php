<?php 
	use Celebgramme\Models\Setting;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr>
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
        <?php if ($data_arr->error_cred) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-error" data-id="{{$data_arr->setting_id}}"></i>
        <?php } ?>
      </td>
      <td align="center">
				<a href="#" class="see-update">lihat updates </a> |
				<a href="#" class="see-all">lihat semua </a>
				<ul style="display:none;" class="data-updates">
					<?php 
					$strings =  explode("|", substr($data_arr->description,12));
					foreach ($strings as $string){
					?>
					<li> {{$string}} </li>
					<?php } ?>
				</ul>
				<?php  
					$setting = Setting::find($data_arr->setting_id);
				?>
				<ul style="display:none;" class="data-all">
					<li>Insta username : {{$setting->insta_username}}</li>
					<li>Insta password : {{$setting->insta_password}}</li>
					<li>Activity : {{$setting->activity}}</li>
					<li>Comments : {{$setting->comments}}</li>
					<li>Tags : {{$setting->tags}}</li>
					<li>Username : {{$setting->username}}</li>
					<li>Activity speed : {{$setting->activity_speed}}</li>
					<li>Media source : {{$setting->media_source}}</li>
					<li>Media age : {{$setting->media_age}}</li>
					<li>Media type : {{$setting->media_type}}</li>
					<li>Min likes media : {{$setting->min_likes_media}}</li>
					<li>Max likes media : {{$setting->max_likes_media}}</li>
					<li>Dont comment same user : {{$setting->dont_comment_su}}</li>
					<li>Follow source : {{$setting->follow_source}}</li>
					<li>Dont follow same user : {{$setting->dont_follow_su}}</li>
					<li>Dont follow private user : {{$setting->dont_follow_pu}}</li>
					<li>Unfollow source : {{$setting->unfollow_source}}</li>
					<li>Unfollow who dont follow me : {{$setting->unfollow_wdfm}}</li>
					<li>Unfollow who usernames whitelist : {{$setting->usernames_whitelist}}</li>
					<li>Status : {{$setting->status}}</li>
				</ul>
      </td>
      <td align="center">
        {{$data_arr->updated_at}}
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

