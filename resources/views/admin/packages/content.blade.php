<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='9' align='center'>Data tidak ada</td></tr>";
  } else {

  $i = $data->firstItem();
  foreach ($data as $index => $arr) {
?>
    <tr>
      <td align="center">{{$i++}}</td>
      <td align="center">{{$arr->package_name}}</td>
      <td align="center">{{ number_format($arr->package_price) }}</td>
      <?php //if ($user->level==1) { ?>
        <td data-label="Edit" align="center">
            <a class="btn btn-warning" href="{{ URL::ROUTE('edit-package', $arr->id) }}"><i class="glyphicon glyphicon-pencil"></i> edit</a>
            <a class="btn btn-info" href="{{ URL::ROUTE('add-package-meta', $arr->id) }}"><i class="glyphicon glyphicon-plus"></i> </a>        
            <a class="btn btn-info" href="#" onclick="return showHiddenContent('{{ $arr->id }}')"><i class="glyphicon glyphicon-duplicate"></i> meta</a>        
            <a disabled="disabled" class="btn btn-danger deleteButton" href="{{ URL::ROUTE('delete-package', $arr->id) }}"
            onclick="return confirm('are you sure you want to delete this package?')"><i class="glyphicon glyphicon-trash"></i> delete</a>
        </td>
      <?php //} ?>
    </tr>    
	<tr class="display-none" id="{{ $arr->id }}">
		<td colspan="4" align="center">
			<table class="table">
			@if(count($metas) > 0)
				<tr>
					@foreach($metas as $meta)
						@if($meta->package_id == $arr->id)
							<td>{{ $meta->meta_name }}</td>
						@endif
					@endforeach
				</tr>
				<tr>
					@foreach($metas as $meta)
						@if($meta->package_id == $arr->id)
							<td>{{ $meta->meta_value }}</td>
						@endif
					@endforeach
				</tr>
			@endif
			</table>
		</td>
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
        )->setPath('packages')->render() !!}
    </td>
</tr>