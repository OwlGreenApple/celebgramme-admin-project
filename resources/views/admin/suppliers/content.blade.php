<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='9' align='center'>tidak ada data</td></tr>";
  } else {
  $i = $data->firstItem();
  foreach ($data as $index => $arr) {
?>
    <tr>
      <td align="center">{{$i++}}</td>
      <td align="center">{{$arr->supplier_company_name}}</td>
      <td align="center">{{$arr->supplier_address}}</td>
      <td align="center">{{$arr->supplier_phone}}</td>
      <?php //if ($user->level==1) { ?>
        <td data-label="Edit" align="center">
            <a class="btn btn-warning" href="{{ URL::ROUTE('edit-supplier', $arr->id) }}"><i class="glyphicon glyphicon-pencil"></i> edit</a>
            <a disabled="disabled" class="btn btn-danger deleteButton" href="{{ URL::ROUTE('delete-supplier', $arr->id) }}"
            onclick="return confirm('are you sure you want to delete this suppliers?')"><i class="glyphicon glyphicon-trash"></i> delete</a>
        </td>
      <?php //} ?>
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
        )->setPath('suppliers')->render() !!}
    </td>
</tr>