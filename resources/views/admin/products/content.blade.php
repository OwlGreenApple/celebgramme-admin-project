<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='9' align='center'>Data tidak ada</td></tr>";
  } else {

  $i = $data->firstItem();
  foreach ($data as $index => $arr) {
?>
    <tr>
      <td align="center">{{$i++}}</td>
      <td align="center">{{$arr->product_name}}</td>
      <td align="center">{{ number_format($arr->product_price) }}</td>
      <td align="center">{{$arr->product_condition}}</td>
      <td align="center">{{$arr->product_location}}</td>
      <td align="center">{{$arr->product_description}}</td>
      <td align="center">{{$arr->product_stock}}</td>
      <td align="center">{{$arr->product_weight}}</td>
      <td align="center">{{$arr->supplier_company_name}}</td>
      <td align="center">{{$arr->category_name}}</td>
      <td align="center"><?php if ($arr->product_view) { echo "showed";} else { echo "hidden";}?></td>
	  <td align="center">
            <a class="btn btn-info" onclick="getImage({{$arr->pid}},'{{ url('load-list-image') }}');"><i class="glyphicon glyphicon-picture"></i> images</a>
      <?php //if ($user->level==1) { ?>
            <a class="btn btn-warning" href="{{ URL::ROUTE('edit-product', $arr->product_slug) }}"><i class="glyphicon glyphicon-pencil"></i> edit</a>
            <a class="btn btn-info" href="{{ URL::ROUTE('add-product-meta', $arr->product_slug) }}"><i class="glyphicon glyphicon-plus"></i> </a>
            <a class="btn btn-info" href="#" onclick="return showHiddenContent('{{ $arr->product_slug }}')"><i class="glyphicon glyphicon-duplicate"></i> meta</a>
            <a disabled="disabled" class="btn btn-danger deleteButton" href="{{ URL::ROUTE('delete-product', $arr->product_slug) }}"
            onclick="return confirm('are you sure you want to delete this product?')"><i class="glyphicon glyphicon-trash"></i> delete</a>
      <?php //} ?>
	  </td>
    </tr>
	<tr class="myhide" id="image-tr-{{ $arr->pid }}"><td align="center" colspan="11" id="image-list-{{ $arr->pid }}"></td></tr>
	<tr class="display-none" id="{{ $arr->product_slug }}">
		<td colspan="5" align="center">
			<table class="table table-bordered">
			@if(count($metas) > 0)
				<tr>
					@foreach($metas as $meta)
						@if($meta->product_id == $arr->id)
							<td>{{ $meta->meta_name }}</td>
						@endif
					@endforeach
				</tr>
				<tr>
					@foreach($metas as $meta)
						@if($meta->product_id == $arr->id)
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
        )->setPath('products')->render() !!}
    </td>
</tr>