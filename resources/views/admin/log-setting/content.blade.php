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
		if ($i>=300){
			break;
		}
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td>
        {{$data_arr->email." / ".$data_arr->insta_username}}
      </td>
      <td>
        <?php 
					$ip_login="";
					echo $data_arr->description;
				?>
      </td>
      <td>
        <?php 
					$ip_activity="";
					echo $data_arr->description;
				?>
      </td>
      <td>
        {{$data_arr->status}}
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

