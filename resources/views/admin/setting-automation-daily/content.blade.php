<?php 
	use Celebgramme\Models\SettingMeta; 
	use Celebgramme\Models\SettingHelper; 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='8' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
		if ($data_arr->server_automation == "AA1(automation-1)") {
			$server = "http://185.225.104.62/";
		}
		if ($data_arr->server_automation == "AA2(automation-2)") {
			$server = "http://185.206.83.2/";
		}
		if ($data_arr->server_automation == "AA3(automation-3)") {
			$server = "http://185.225.104.57/";
		}
		if ($data_arr->server_automation == "A4(automation-4)") {
			$server = "http://185.206.83.5/";
		}
		if ($data_arr->server_automation == "AA5(automation-5)") {
			$server = "http://185.225.104.54/";
		}
		if ($data_arr->server_automation == "AA6(automation-6)") {
			$server = "http://185.206.82.66/";
		}
		if ($data_arr->server_automation == "AA7(automation-7)") {
			$server = "http://185.225.104.51/";
		}
		if ($data_arr->server_automation == "AA8(automation-8)") {
			$server = "http://185.206.82.69/";
		}
		if ($data_arr->server_automation == "AA9(automation-9)") {
			$server = "http://185.225.104.49/";
		}
		if ($data_arr->server_automation == "AA10(automation-10)") {
			$server = "http://185.206.83.8/";
		}
		if ($data_arr->server_automation == "AA12(automation-12)") {
			$server = "http://185.225.104.45/";
		}
		if ($data_arr->server_automation == "AA13(automation-13)") {
			$server = "http://103.102.46.153/";
		}
		if ($data_arr->server_automation == "AA14(automation-14)") {
			$server = "http://103.102.46.220/";
		}
		if ($data_arr->server_automation == "AA15(automation-15)") {
			$server = "http://103.102.46.138/";
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
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$content = curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo $content."</td>";	
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
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$content = curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo $content."</td>";	
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
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$content = curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo $content."</td>";	
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
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$content = curl_exec($ch);
					$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ($retcode==200) { // $retcode >= 400 -> not found, $retcode = 200, found.
						echo $content."</td>";	
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

