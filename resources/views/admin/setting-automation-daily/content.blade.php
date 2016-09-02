<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\SettingHelper; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
		if ($data_arr->server_automation == "A1(automation-1)") {
			$server = "http://192.186.146.248/";
		}
		if ($data_arr->server_automation == "A2(automation-2)") {
			$server = "http://192.186.146.246/";
		}
		if ($data_arr->server_automation == "A3(automation-3)") {
			$server = "http://188.210.215.104/";
		}
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$data_arr->insta_username." / ".$data_arr->start_time}} 
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
					$file_server = $server."daily-action-counter/".$data_arr->insta_username."/".$day."/"."unfollow.txt";
					$ch = curl_init($file_server);
					curl_setopt($ch, CURLOPT_NOBODY, true);
					curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo file_get_contents($file_server)."</td>";	
					} else {
						echo " 0 ";
					}
					curl_close($ch);
				?>
      </td>
			<td align="center">
        <?php 
					$file_server = $server."daily-action-counter/".$data_arr->insta_username."/".$day."/"."follow.txt";
					$ch = curl_init($file_server);
					curl_setopt($ch, CURLOPT_NOBODY, true);
					curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo file_get_contents($file_server)."</td>";	
					} else {
						echo " 0 ";
					}
					curl_close($ch);
				?>
      </td>
			<td align="center">
        <?php 
					$file_server = $server."daily-action-counter/".$data_arr->insta_username."/".$day."/"."like.txt";
					$ch = curl_init($file_server);
					curl_setopt($ch, CURLOPT_NOBODY, true);
					curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo file_get_contents($file_server)."</td>";	
					} else {
						echo " 0 ";
					}
					curl_close($ch);
				?>
      </td>
			<td align="center">
        <?php 
					$file_server = $server."daily-action-counter/".$data_arr->insta_username."/".$day."/"."comment.txt";
					$ch = curl_init($file_server);
					curl_setopt($ch, CURLOPT_NOBODY, true);
					curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo file_get_contents($file_server)."</td>";	
					} else {
						echo " 0 ";
					}
					curl_close($ch);
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
				{{$data_arr->activity_speed}}
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

