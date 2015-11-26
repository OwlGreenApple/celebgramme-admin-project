<?php 
  if ( ($tb_konfirmasi_premi->count()==0) ) {
    echo "<tr><td colspan='15' align='center'>Data tidak ada</td></tr>";
  } else {

  $i=($page-1)*15 + 1;
  foreach ($tb_konfirmasi_premi as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$arr->created}}
      </td>
      <td>
        {{$arr->nopolis}}
      </td>
      <td>
        {{$arr->username}}
      </td>
      <td align="center">
        {{$arr->nama}}
      </td>
      <td align="center" class="data-nohp">
        {{$arr->nohp}}
      </td>
      <td align="center" class="data-email">
        {{$arr->email}}
      </td>
      <td align="center" class="data-jumlah">
        {{number_format($arr->jenis_premi,0,'','.')}}
      </td>
      <td align="center" class="data-topup">
        {{number_format($arr->topup,0,'','.')}}
      </td>
      <td align="center" class="data-total">
        {{number_format($arr->jumlah,0,'','.')}}
      </td>
      <td align="center">
        <?php if ($arr->bank<>'') { ?>
        {{$arr->bank}} / {{$arr->norek}}
        <?php } ?>
      </td>
      <td align="center">
        {{$arr->bank_tujuan}}
      </td>
      <td align="center">
        <a href="" class="popup-newWindow"><img src="http://axiapro.com/member/uploads/konfirmasi_premi/{{$arr->attachment}}" style="width:70px;"></a>
      </td>
      <td align="center">
        <?php if ($arr->status=='1') { ?>
          <i class="checked-icon"></i>
        <?php } else { ?>
          <i class="x-icon" data-id="{{$arr->id}}"></i>
        <?php } ?>
      </td>
      <?php if ($user->level==1) { ?>
        <td data-label="Edit" class="set-center">
            <input type="button" value="Edit" id="button-adit" data-loading-text="Loading..." onclick="callEditConfirm({{ $arr->id }});" class="btn btn-warning">
        </td>
      <?php } ?>
      
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

