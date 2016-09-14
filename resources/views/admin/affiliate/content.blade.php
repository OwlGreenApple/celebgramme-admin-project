<?php 
	use Celebgramme\Models\SettingHelper;
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
			{{$arr->nama}}
      </td>
      <td align="center">
			{{$arr->link}}
      </td>
      <td align="center">
			{{$arr->jumlah_hari_free_trial}}
      </td>
      <td align="center">
			{{$arr->jumlah_user_daftar}}
      </td>
      <td align="center">
			{{$arr->jumlah_user_beli}}
      </td>
      <td align="center">
			{{$arr->created}}
      </td>
      <td align="center">
				<input type="button" class="btn btn-info button-edit" value="Edit" data-toggle="modal" data-target="#modal-affiliate" data-id="{{$arr->id}}" data-nama="{{$arr->nama}}" data-link="{{$arr->link}}" data-hari="{{$arr->jumlah_hari_free_trial}}">
				
				<input type="button" class="btn btn-danger btn-delete" value="Delete" data-toggle="modal" data-target="#confirm-delete" data-id="{{$arr->id}}">

      </td>
      
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

