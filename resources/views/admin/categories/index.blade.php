@extends('layout.main')

@section('content')
<style>
	.wrap{
		white-space: pre-wrap;      /* CSS3 */   
		white-space: -moz-pre-wrap; /* Firefox */    
		white-space: -pre-wrap;     /* Opera <7 */   
		white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */		
		width:350px;
	}
.ui-autocomplete {
    z-index:9050!important;
}	
</style>

<link href="{{ asset('/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('/selectize/js/standalone/selectize.js') }}"></script>

  <div class="modal fade" id="myModalUpdateCategories" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Categories</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-update-categories">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Name Categories</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Name Categories" name="categories" id="categories">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Categories Value</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Categories Value" name="name" id="name">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Hashtags</label>
              <div class="col-sm-8 col-md-6">
								<textarea class="selectize-default" id="textarea-hashtags" name="hashtags"></textarea>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Username</label>
              <div class="col-sm-8 col-md-6">
								<textarea class="selectize-default" id="textarea-username" name="username"></textarea>
              </div>
            </div>  
            <input type="hidden" class="category-id" name="category-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-update-categories" data-check="auto">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Categories
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-categories-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	


  <div class="page-header">
    <h1>Categories</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
			<input type="text" class="form-control" placeholder="category name" id="keyword-search">
    </div>  
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add" id="button-add" data-loading-text="Loading..." class="btn btn-primary"data-toggle="modal" data-target="#myModalUpdateCategories"> 
    </div>  
    <div class="none"></div>
  </div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <nav id="pagination1">
  </nav>  
  <table class="table table-bordered">  
    <thead>
      <tr style="font-weight:bold;">
        <th>No. </th>
        <th>Categories</th>
        <th>Value</th>
        <th>Hashtags</th>
        <th>Username</th>
        <th>created</th>
        <th colspan=2></th>
				
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination2">
  </nav>  
	
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-categories'); ?>',
        type: 'get',
        data: {
          page: page,
					keyword: $("#keyword-search").val(),
					// filename: $("#file-name").val(),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#content').html(result);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-categories'); ?>',
        type: 'get',
        data: {
          page : page,
					keyword: $("#keyword-search").val(),
					// filename: $("#file-name").val(),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#pagination1').html(result);
          $('#pagination2').html(result);
          
          $('#pagination1 a').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            if ($(this).html() == "«") {
              page -= 1; 
            } else 
            if ($(this).html() == "»") {
              page += 1; 
            } else {
              page = parseInt($(this).html());
            }
            create_pagination(page);
            refresh_page(page);
          });
					
          $('#pagination2 a').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            if ($(this).html() == "«") {
              page -= 1; 
            } else 
            if ($(this).html() == "»") {
              page += 1; 
            } else {
              page = parseInt($(this).html());
            }
            create_pagination(page);
            refresh_page(page);
          });
          
          // $("#div-loading").hide();
        }
      });
    }
		var selectS;
    function refreshSelectize() {
			  selectS = $('.selectize-default').selectize({
				plugins:['remove_button'],
				delimiter: ';',
				persist: false,
				onChange: function(value) {
								 // alert(value);
					// console.log($(this).parent());
				},
				create: function(input) {
					return {
						value: input,
						text: input
					}
				},
			});
    }
    $(document).ready(function(){
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);

			refreshSelectize();
			
			// show current input values
			$('textarea.selectize-default,select.selectize-default,input.selectize-default').each(function() {
				var $container = $('<div style="font-size:11px;">').addClass('value').html('Current count: ');
				var $value = $('<span>').appendTo($container);
				var $input = $(this);
				var update = function(e) { 
					// $value.text(JSON.stringify($input.val())); 

					var str,res;
					str = JSON.stringify($input.val());
					res = str.split(";");
					if ($input.val() == "") {
						$value.text("0"); 
					} else {
						$value.text(res.length); 
					}
					// console.log(res.length);
					// $container.insertAfter($input.next());
				}

				$(this).on('change', update);
				update();

				$container.insertAfter($input.next());
				
				// $container.insertAfter($input.next());
			});
			
			
			$('#button-add').click(function(e){
				$(".category-id").val("new");
				$("#name").val("");
				$("#categories").val("");
				
				// fetch the instance
				var selectize = selectS[0].selectize;
				selectize.destroy();
				var selectize = selectS[1].selectize;
				selectize.destroy();
				$("#textarea-hashtags").val("");
				$("#textarea-username").val("");
				
				refreshSelectize();
      });
			$( "body" ).on( "click", ".btn-update", function() {
				$(".category-id").val($(this).attr("data-id"));
				$("#name").val($(this).attr("data-name"));
				$("#categories").val($(this).attr("data-categories"));
				
				// fetch the instance
				var selectize = selectS[0].selectize;
				selectize.destroy();
				var selectize = selectS[1].selectize;
				selectize.destroy();
				$("#textarea-hashtags").val($(this).attr("data-hashtags"));
				$("#textarea-username").val($(this).attr("data-username"));
				
				refreshSelectize();
      });
			$('#btn-update-categories').click(function(e){
        $.ajax({
          url: '<?php echo url('update-categories'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-update-categories").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
							create_pagination(1);
							refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
			});

			$( "body" ).on( "click", ".btn-delete", function() {
				$("#id-categories-delete").val($(this).attr("data-id"));
      });
			
			$('#button-delete').click(function(e){
        $.ajax({
          url: '<?php echo url('delete-categories'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id:$("#id-categories-delete").val()
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
							create_pagination(1);
							refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
			
			$('#button-search').click(function(e){
				create_pagination(1);
				refresh_page(1);
			});
			
    });
  </script>		
  
@endsection
