<?php 
  $i=1;
  foreach ($referrals as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$arr->fullname}}
      </td>
      <td align="center">
        {{$arr->email}}
      </td>
      <td align="center">
        {{$arr->jmlrefer}}
      </td>
    </tr>    
<?php 
    $i+=1;
  } 
?>

