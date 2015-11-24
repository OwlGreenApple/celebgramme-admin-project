@foreach ($images as $image)
	<img class="inline-block" src="{{ VIEW_IMG_PATH.'products/'.$image->meta_value }}" width="200px" height="200px" />
@endforeach