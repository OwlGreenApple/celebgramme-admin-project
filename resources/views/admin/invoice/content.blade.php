<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='25' align='center'>Data belum di generate</td></tr>";
  } 
  $i=($page-1)*15 + 1;
  foreach ($data as $arr) {
?>
    <tr>
      <td>
        {{$i}}
      </td>
      <td style="text-align:center">
        {{$arr->no_invoice}}
      </td>
      <td style="text-align:right">{{number_format($arr->total,0,'','.')}}</td>
    </tr>    

<?php 
    $i+=1;
  } 
?>

