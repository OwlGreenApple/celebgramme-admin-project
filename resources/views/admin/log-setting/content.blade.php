<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\User;
	use Celebgramme\Models\SettingHelper; 
	use Celebgramme\Models\Proxies; 
	use Celebgramme\Models\AutoResponderSetting; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr class="{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td>
        <?php 
					$data_arr->email;
					$email = "";
					$insta_username = "";
					$url_setting = url("setting")."/".$insta_username;
					echo $email." / <a href='".$url_setting."' target='_blank'>".$insta_username."</a>";
				?>
      </td>
      <td>
        <?php 
					echo $data_arr->description;
				?>
      </td>
      <td>
        {{$data_arr->created}}
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

