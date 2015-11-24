<?php 
  if ( ($data->count()==0) ) {
    echo "<tr><td colspan='9' align='center'>Data tidak ada</td></tr>";
  } else {

  $i = $data->firstItem();
  foreach ($data as $index => $arr) {
?>
    <tr>
      <td align="center">{{$i++}}</td>
      <td align="center">{{$arr->category_name}}</td>
      <td align="center">{{$arr->category_description}}</td>
      <td align="center">{{$arr->category_type}}</td>
	  <?php
		if($arr->category_type == "category"){
			$path = VIEW_IMG_PATH.'categories/';
		}elseif($arr->category_type == "catalog"){
			$path = VIEW_IMG_PATH.'catalogs/';
		}elseif($arr->category_type == "promo"){
			$path = VIEW_IMG_PATH.'catalogs/';
		}
	  ?>
      <td align="center"><img width="50px" height="50px" src="{{ $path.$arr->category_image}}"/> </td>
      <?php //if ($user->level==1) { ?>
        <td data-label="Edit" align="center">
            <a class="btn btn-warning" href="{{ URL::ROUTE('edit-product-category', $arr->category_slug) }}"><i class="glyphicon glyphicon-pencil"></i> edit</a>
            <a class="btn btn-success" href="{{ URL::ROUTE('add-sub-product-category', $arr->category_slug) }}"><i class="glyphicon glyphicon-plus"></i> sub category</a>
            <a class="btn btn-info" href="{{ URL::ROUTE('add-sub-product-category', $arr->category_slug) }}"><i class="glyphicon glyphicon-plus"></i> </a>
            <a class="btn btn-info" href="#" onclick="return showHiddenContent('{{ $arr->category_slug }}')"><i class="glyphicon glyphicon-duplicate"></i> meta</a>
            <a disabled="disabled" class="btn btn-danger deleteButton" href="{{ URL::ROUTE('delete-product-category', $arr->category_slug) }}"
            onclick="return confirm('are you sure you want to delete this category?')"><i class="glyphicon glyphicon-trash"></i> delete</a>
        </td>
      <?php //} ?>
    </tr>    
	<tr class="display-none" id="{{ $arr->category_slug }}">
		<td colspan="5" align="center">
			<table class="table table-bordered">
			@if(count($metas) > 0)
				<tr>
					@foreach($metas as $meta)
						@if($meta->product_category_id == $arr->id)
							<td>{{ $meta->meta_name }}</td>
						@endif
					@endforeach
				</tr>
				<tr>
					@foreach($metas as $meta)
						@if($meta->product_category_id == $arr->id)
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
        )->setPath('product-categories')->render() !!}
    </td>
</tr>