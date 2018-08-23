<?php 
	use Celebgramme\Models\UserMeta;
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {

  foreach ($arr as $data_arr) {
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$data_arr->created_at}}
      </td>
      <td>
        {{$data_arr->description}}
      </td>
    </tr>    
<?php 
    
  } 
  }
?>
<script>
  $(document).ready(function(){
  });

</script>		

