<?php 
  use Celebgramme\Models\Coupon;
  use Celebgramme\Models\Package;
  if ( ($order->count()==0) ) {
    echo "<tr><td colspan='15' align='center'>Data tidak ada</td></tr>";
  } else {

  $i=($page-1)*15 + 1;
  foreach ($order as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        <?php  if ($arr->updated_at<>$arr->created_at)  { echo "Confirmed"; }
        else  if ($arr->updated_at==$arr->created_at) { echo "Not Confirmed";  }
        ?>
      </td>
      <td align="center">
        <?php  if ($arr->updated_at<>$arr->created_at) echo $arr->updated_at; ?>
				<br>
				{{$arr->no_order}}
      </td>
      <td align="center">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-more" data-header="Nama Bank" data-id="{{$arr->id}}" data-action="nama bank"> Show </button>
      </td>
      <td align="center">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-more" data-header="No Rekening" data-id="{{$arr->id}}" data-action="no rekening"> Show </button>
      </td>
      <td align="center">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btn-show" data-target="#show-more" data-header="Nama Pemilik Rekening" data-id="{{$arr->id}}" data-action="nama pemilik rekening"> Show </button>
      </td>
      <td align="center">
        {{$arr->email." ".$arr->fullname}}
      </td>

      <td align="center" class="data-nohp">
        {{number_format($arr->total - $arr->discount,0,'','.')}}
      </td>
      <td align="center">
        <?php 
					if ($arr->type == "daily-activity") {
						$package = Package::find($arr->package_manage_id);
						if (!is_null($package)) { echo $package->package_name;} else { echo "-";}
					}
					else if ($arr->type == "max-account") {
						echo $arr->added_account." Akun";
					}
        ?>
      </td>
      <td align="center">
        <a href="" class="popup-newWindow"><img src="{{VIEW_IMG_PATH.'confirm-payment/'.$arr->image}}" style="width:70px;"></a>
      </td>
      <td align="center">
        <?php if ($arr->checked) { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon" data-id="{{$arr->id}}"></i>
        <?php } ?>
      </td>
      
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

