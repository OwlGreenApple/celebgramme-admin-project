<?php 
  foreach ($refers as $arr) {
?>
      <tr class=".row-{{$arr->id}}">
        <td> 
          {{$arr->fullname}}      
        </td>
        <td>  
          {{$arr->email}}
        </td>  
        <td>
          {{$arr->bonus}}
        </td>
        <td>
          <?php 
            if($arr->is_confirm==1) {
              echo 'Yes';
            } else {
              echo 'No';
            }
          ?>
        </td> 
        <td>
          {{$arr->created_at}}
        </td>   
      </tr>
<?php 
  } 
?> 