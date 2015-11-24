<?php 
  if ($config_packages->count()==0)
    echo "<tr><td colspan='8' align='center'>Data belum di generate</td></tr>";
  foreach ($config_packages as $arr) {
?>
    <tr>
      <td align="center">
        {{$arr['id']}}
      </td>
      <td align="center">
        {{$arr['name']}}
      </td>
      <td align="center">
        {{number_format($arr['value'],0,'','.')}}
      </td>
      <td align="center">
        {{$arr['bonus_pv']}}
      </td>
      <td align="center">
        {{$arr['type']}}
      </td>
      <td align="center">
        {{number_format($arr['permonth_value'],0,'','.')}}
      </td>
      <td align="center">
        <input type="checkbox" <?php if ($arr['showed']) { echo "checked";} ?> disabled>
      </td>
      <td align="center">
        <?php echo Form::open(['method' => 'get', 'route' => ['config-package.edit', $arr["id"]], 'class'=>'form-submit']); ?>
          <input type="submit" value="Edit" data-loading-text="Loading..." class="btn btn-primary edit-package">
        </form>
        <?php echo Form::open(['method' => 'DELETE', 'route' => ['config-package.destroy', $arr["id"]], 'class'=>'form-submit']); ?>
            <?php echo Form::submit('Delete', ['class' => 'btn btn-danger']) ?>
        <?php echo Form::close() ?>        
      </td>
    </tr>    
<?php 
  } 
?>

