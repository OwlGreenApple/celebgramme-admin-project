<?php 
	use Celebgramme\Models\SettingHelper;
	use Celebgramme\Models\Account;
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {

  $i=($page-1)*15 + 1;
  foreach ($data as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$i}}
      </td>
      <td align="center">
			<?php 
				if ($arr->is_error) {
					echo "error";
				}
			?>
			{{$arr->proxy}}
      </td>
      <td align="center">
			{{$arr->cred}}
      </td>
      <td align="center">
			{{$arr->port}}
      </td>
      <td align="center">
			<?php 
				$counter = SettingHelper::where("proxy_id","=",$arr->id)->count();
				$counter += Account::where("proxy_id","=",$arr->id)->where("is_on_celebgramme","=",0)->count();
				echo $counter;
			?>
      </td>
			<td align="center">
				Celebgramme : <br>
				<?php 
					$settings = SettingHelper::join("settings","settings.id","=","setting_helpers.setting_id")
											->where("proxy_id","=",$arr->id)
											->get();
					foreach($settings as $setting) {
						echo $setting->insta_username."<br>";
					}
				?>
				<br>
				Celebpost : <br>
				<?php 
					$accounts = Account::where("proxy_id","=",$arr->id)->where("is_on_celebgramme","=",0)->get();
					foreach($accounts as $account) {
						echo $account->username."<br>";
					}
				?>
      </td>
      <td align="center">
			{{$arr->created}}
      </td>
      <td align="center">
				<input type="button" class="btn btn-info button-edit-proxy" value="Edit" data-toggle="modal" data-target="#modal-proxy" data-id="{{$arr->id}}" data-proxy="{{$arr->proxy}}" data-cred="{{$arr->cred}}" data-port="{{$arr->port}}" data-is_local_proxy="{{$arr->is_local_proxy}}">
				
				<input type="button" class="btn btn-danger btn-delete" value="Delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$arr->id}}">

				<input type="button" class="btn btn-danger btn-exchange-proxy" value="Exchange" data-toggle="modal" data-target="#modal-exchange-proxy" data-id="{{$arr->id}}">

      </td>
      
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

