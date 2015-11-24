      <div class="block">
				<div class="form-group inline-block">
                    {!! Form::label('name','Name:') !!}
                    {!! Form::text('product_name',null,["class"=>"form-control width400","required"=>"true"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','Price:') !!}
                    {!! Form::text('product_price',null,["class"=>"form-control width200","required"=>"true"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','Discount:') !!}
                    {!! Form::text('product_discount',null,["class"=>"form-control width200","required"=>"true"]) !!}
                </div>
			</div>
			<div class="block">
				<div class="form-group inline-block">
                    {!! Form::label('name','Stock:') !!}
                    {!! Form::text('product_stock',null,["class"=>"form-control width50","required"=>"true"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','Weight:') !!}
                    {!! Form::text('product_weight',null,["class"=>"form-control width50","required"=>"true"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','Location:') !!}
                    {!! Form::text('product_location',null,["class"=>"form-control width200"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','Condition:') !!}
                    {!! Form::text('product_condition',null,["class"=>"form-control width200"]) !!}
                </div>
			</div>

				<div class="form-group inline-block">
                    {!! Form::label('name','Supplier:') !!}
                    {!! Form::select('supplier_id',$suppliers,null,["class"=>"form-control width300","required"=>"true"]) !!}
                </div>
				<div class="form-group inline-block">
                    {!! Form::label('name','view:') !!}
                    {!! Form::checkbox('product_view',null,["class"=>"form-control"]) !!}
                </div>
				<div class="form-group">
                    {!! Form::label('description','Desciptions:') !!}
                    {!! Form::textarea('product_description',null,["class"=>"form-control"]) !!}
                </div>
				<div class="form-group">
					{!! Form::label('','Main Image: ') !!}
				</div>
				
				<label for="image-main" id="imageLabel" class="width200 height200">
						@if(isset($product->product_image))
							<img id="image-preview-main" src="{{ VIEW_IMG_PATH.'products/'.$product->product_image }}" class="image-add-icon"/>
						@else
							<img id="image-preview-main" src="{{ asset('/images/upload-image.png') }}" class="image-add-icon"/>
						@endif
						{!! Form::file('product_image', ["class"=>"display-none","id"=>"image-main","onchange"=>"DisplayChosenImage('main')"]); !!}
				</label>
				
				<div class="form-group">
					{!! Form::label('','Upload Image: ') !!}
				</div>
				<?php $index = 0; ?>
				@if(isset($image) && count($image) > 0)
					@foreach($image as $index => $img)
						<div class="image-upload-placeholder">
							<label for="image-<?php echo $index ?>" id="imageLabel" class="width200 height200">
								<img id="image-preview-<?php echo $index; ?>" src="{{ VIEW_IMG_PATH.'products/'.$img->meta_value }}" class="image-add-icon"/>
								{!! Form::file('meta_value['.$index.']', ["class"=>"display-none","id"=>"image-".($index),"onchange"=>"addMoreImage(".($index).")"]); !!}
							</label>
							<label id="imageDelete" onclick="deleteThisImage({{ $img->meta_id }})" class="image-delete">
								<img id="image-preview-{{ $index }}" src="{{ asset('/images/delete.png') }}" class="image-del-icon">
							</label>
						</div>
					@endforeach
					<?php $index += 1; ?>
				@endif
				@if($index <= 4)
					<div class="form-group image-upload">
						<div class="image-upload-placeholder">
							<label for="image-{{ $index }}" id="imageLabel" class="width200 height200">
								<img id="image-preview-{{ $index }}" src="{{ asset('/images/upload-image.png') }}" class="image-add-icon"/>
							</label>
							{!! Form::file('meta_value[]', ["class"=>"display-none","id"=>"image-".($index),"onchange"=>"addMoreImage(".($index).")"]); !!}
						</div>
						<div id="more-image"></div>
					</div>
				@endif
				
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>
				<script>
					function deleteThisImage(id){
						var r = confirm("Delete this image!");
						if (r == true) {
							$.ajax({
								url: '<?php echo url('delete-product-meta'); ?>',
								type: 'get',
								data: {
									id: id
								},
								dataType: 'text',
								success: function(result){
									location.reload();
								}
							});
						}
					}
					function DisplayChosenImage(x){
						var reader = new FileReader();
						reader.onload = function (e) {
							document.getElementById("image-preview-"+x).src = e.target.result;
						};
						reader.readAsDataURL(document.getElementById("image-"+x).files[0]);
					}
					function addMoreImage(x){
						var id = x+1;
						DisplayChosenImage(x);
						if(document.getElementById("image-preview-"+id) == null){
							if(id <= 4){
								var $html = "<div class='image-upload-placeholder'>";
								$html += "<label for='image-"+id+"' class='width200 height200'>";
								$html += "<img id='image-preview-"+id+"' src='{{ asset('/images/upload-image.png') }}' class='image-add-icon'/>";
								$html += "</label>";						
								$html += '<input class="display-none" id="image-'+id+'" onchange="addMoreImage('+id+')" name="meta_value[]" type="file">';
								$html += "</div>";
								$("#more-image").append($html);
							}
						}
					}
				</script>