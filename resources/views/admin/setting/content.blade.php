<?php 
	use Celebgramme\Models\SettingMeta; 
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
        {{$data_arr->insta_username}}
      </td>
      <td align="center">
        {{$data_arr->insta_password}}
      </td>
      <td align="center">
				<p class="fl-filename">
				<?php 
					$filename = "";
					if (SettingMeta::getMeta($data_arr->id,"fl_filename") <> "0" ) {
						$filename = SettingMeta::getMeta($data_arr->id,"fl_filename");
						echo $filename."";
					}
				?>
				<span type="button" value="edit" data-loading-text="Loading..." class="glyphicon glyphicon-pencil btn-fl-edit" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}"
				data-filename="{{$filename}}" style="cursor:pointer;">  </span>
				</p>
      </td>
      <td align="center">
        <?php if ($data_arr->error_cred) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon update-error" data-id="{{$data_arr->id}}"></i>
        <?php } ?>
      </td>
      <td align="center">
				<a href="#" class="see-all">lihat semua </a>
				<ul style="display:none;" class="data-all">
					<li>Insta username : {{$data_arr->insta_username}}</li>
					<li>Insta password : {{$data_arr->insta_password}}</li>
					<li>Activity : {{$data_arr->activity}}</li>
					<li>Comments : {{$data_arr->comments}}</li>
					<li>Tags : {{$data_arr->tags}}</li>
					<li>Username : {{$data_arr->username}}</li>
					<li>Activity speed : {{$data_arr->activity_speed}}</li>
					<li>Media source : {{$data_arr->media_source}}</li>
					<li>Media age : {{$data_arr->media_age}}</li>
					<li>Media type : {{$data_arr->media_type}}</li>
					<li>Min likes media : {{$data_arr->min_likes_media}}</li>
					<li>Max likes media : {{$data_arr->max_likes_media}}</li>
					<li>Dont comment same user : {{$data_arr->dont_comment_su}}</li>
					<li>Follow source : {{$data_arr->follow_source}}</li>
					<li>Dont follow same user : {{$data_arr->dont_follow_su}}</li>
					<li>Dont follow private user : {{$data_arr->dont_follow_pu}}</li>
					<li>Unfollow source : {{$data_arr->unfollow_source}}</li>
					<li>Unfollow who dont follow me : {{$data_arr->unfollow_wdfm}}</li>
					<li>Unfollow who usernames whitelist : {{$data_arr->usernames_whitelist}}</li>
					<li>Status : {{$data_arr->status}}</li>
				</ul>
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

