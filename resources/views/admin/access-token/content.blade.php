<?php 
  if ( $arr->count()==0  ) {
    echo "<tr><td colspan='7' align='center'>Data tidak ada</td></tr>";
  } else {
    //search by username
  $i=($page-1)*15 + 1;
  foreach ($arr as $data_arr) {
?>
    <tr class="row{{$data_arr->id}}">
      <td>
        {{$i}}
      </td>
      <td align="center">
        {{$data_arr->insta_username}}
      </td>
      <td align="center">
        
      </td>
      <td align="center" id="access-token">
        {{$data_arr->insta_access_token}}
      </td>
      <td align="center">
        <input type="button" class="btn btn-info btn-update" value="update" data-toggle="modal" data-target="#myModal" data-id="{{$data_arr->id}}" >
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

