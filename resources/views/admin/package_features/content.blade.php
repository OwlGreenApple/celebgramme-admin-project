<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='9' align='center'>Data tidak ada</td></tr>";
  } else {

  $i = $data->firstItem();
  foreach ($data as $index => $arr) {
?>
    <tr>
      <td align="center">{{$i++}}</td>
      <td align="center">{{$arr->feature_name}}</td>
      <td align="center">{{ number_format($arr->feature_value) }}</td>
      <td align="center">{{ $arr->package_name }}</td>
      <?php if ($user->level==1) { ?>
        <td data-label="Edit" class="set-center">
            <a class="btn btn-warning" href="{{ URL::ROUTE('edit-package-feature', $arr->id) }}"><i class="glyphicon glyphicon-pencil"></i> edit</a>
        </td>
        <td data-label="Delete" class="set-center">
            <a disabled="disabled" class="btn btn-danger deleteButton" href="{{ URL::ROUTE('delete-package-feature', $arr->id) }}"
            onclick="return confirm('are you sure you want to delete this package feature?')"><i class="glyphicon glyphicon-trash"></i> delete</a>
        </td>
      <?php } ?>
    </tr>    
<?php 
    
  } 
  }
?>
<tr>
    <td colspan="14" align="center" class="baret">
        {!! $data->appends(
                            [
                                "search"=>Input::get('search'),
                            ]
        )->setPath('package-features')->render() !!}
    </td>
</tr>