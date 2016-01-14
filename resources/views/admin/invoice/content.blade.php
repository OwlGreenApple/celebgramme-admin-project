<?php 
  if ( ($invoices->count()==0) ) {
    echo "<tr><td colspan='15' align='center'>Data tidak ada</td></tr>";
  } else {

  $i=($page-1)*15 + 1;
  foreach ($invoices as $arr) {
?>
    <tr id="tr-{{ $arr->id }}">
      <td>
        {{$arr->no_invoice}}
      </td>
      <td>
        {{$arr->created_at}}
      </td>
      <td>
        {{$arr->fullname}}
      </td>
      <td align="right" class="data-nohp">
        {{number_format($arr->total,0,'','.')}}
      </td>
    </tr>    
<?php 
    $i+=1;
  } 
  }
?>

