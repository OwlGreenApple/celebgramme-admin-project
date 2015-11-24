        <h1>{{$category->category_name}}</h1>
				<div class="form-group">
                    {!! Form::label('parent_id','Parent Category:') !!}
                    {!! Form::select('parent_id',[0=>'Category Utama']+$categories->all(),$id,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
                    {!! Form::label('name','Category:') !!}
                    {!! Form::text('category_name',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description','Desciptions:') !!}
                    {!! Form::text('category_description',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('type','Type:') !!}
                    {!! Form::select('category_type',["category"=>"category","catalog"=>"catalog","promo"=>"promo"],null,["class"=>"form-control","required"=>"true","id"=>"type"]) !!}
                </div>
                
                <div class="row">
                  <div class="col-md-6">                
                    <h3>List Product</h3>
                    <table class="table table-bordered" id="product-table">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Product Price</th>
                          <th>Supplier Name</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($products as $key => $value)
                        <tr data-id="{{$value->id}}">
                          <td align="center" class="product-name">
                            <a href="{{url('edit-product/'.$value->product_slug)}}" target="_blank">
                            {{$value->product_name}}
                            </a>
                          </td>
                          <td align="right" class="product-price">{{number_format($value->product_price,0,'','.')}}</td>
                          <td align="center" class="supplier-name">{{$value->supplier_company_name}}</td>
                          <td align="center"> <input type="button" value="add" class="btn btn-primary button-add-product"> </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="col-md-6">                
                    <h2 id="header-list-product">List Products <?php if ($category->category_type=="") { echo "category"; } else { echo $category->category_type; }  ?></h2>
                    <table class="table table-bordered" id="product-category-link-table">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Product Price</th>
                          <th>Supplier Name</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($link_products as $key => $value)
                        <tr>
                          <td ><a href="{{url('edit-product/'.$value->product_slug)}}" target="_blank">{{$value->product_name}}</a></td>
                          <td >{{number_format($value->product_price,0,'','.')}}</td>
                          <td >{{$value->supplier_company_name}}</td>
                          <td > <input type="button" value="delete" class="btn btn-warning button-delete-link-product-category" data-id="{{$value->id}}"> </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>                 
                  
                </div>
                
                
                <table id="hidden-table">
                  <tbody>
                  @foreach($link_products as $key => $value)
                    <tr id="{{$value->id}}">
                      <input type="hidden" name="arrIdProducts[]" value="{{$value->id}}">
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                
				<div class="form-group">
					{!! Form::label('','Main Image: ') !!}
				</div>
				
				<label for="image-main" id="imageLabel" class="width200 height200">
						@if(isset($category->category_image))
							<img id="image-preview-main" src="{{ VIEW_IMG_PATH.'categories/'.$category->category_image }}" class="image-add-icon"/>
						@else
							<img id="image-preview-main" src="{{ asset('/images/upload-image.png') }}" class="image-add-icon"/>
						@endif
						{!! Form::file('image', ["class"=>"display-none","id"=>"image-main","onchange"=>"DisplayChosenImage('main')"]); !!}
				</label>
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>
				<script>
          $('#product-table').DataTable();
          var product_link_category = $('#product-category-link-table').DataTable();
          $("#type").change(function() {
            $("#header-list-product").html("List Products "+$(this).val());
          });          
          $( "body" ).on( "click", ".button-delete-link-product-category", function() {
            product_link_category.row($(this).parents('tr')).remove().draw();
            $("#hidden-table").find("#"+$(this).attr("data-id")).remove();
          });
          $( "body" ).on( "click", ".button-add-product", function() {
            productId = $(this).parent().parent().attr("data-id");
            flag = false;
 
            // $('#product-category-link-table tbody tr [name="arrIdProducts[]"]').each(function(){
            $('#hidden-table tbody tr [name="arrIdProducts[]"]').each(function(){
              if ( productId == $(this).val() ) {
                // console.log("data sudah ada");
                alert("data sudah ada");
                flag = true;
              }
            }) 
            if (flag) return "";
            // console.log($(this).parent().parent().attr("data-id"));
            // console.log($(this).parent().parent().html());
            // $('#product-category-link-table > tbody:last-child').append("<tr data-id=''>"+$(this).parent().parent().html()+"</tr>");
            $('#hidden-table > tbody:last-child').append('<tr><input type="hidden" name="arrIdProducts[]" value="'+productId+'"></tr>');
            product_link_category.row.add([
              $(this).parent().parent().find(".product-name").html(),
              $(this).parent().parent().find(".product-price").html(),
              $(this).parent().parent().find(".supplier-name").html(),
              '<input type="button" value="delete" class="btn btn-warning button-delete-link-product-category" data-id="'+$(this).parent().parent().attr("data-id")+'">',
              // '<input type="button" value="delete" class="btn btn-warning button-delete-link-product-category"><input type="hidden" name="arrIdProducts[]" value="'+productId+'">',
            ]).draw( false );
          });
					function DisplayChosenImage(x){
						var reader = new FileReader();
						reader.onload = function (e) {
							document.getElementById("image-preview-"+x).src = e.target.result;
						};
						reader.readAsDataURL(document.getElementById("image-"+x).files[0]);
					}
				</script>