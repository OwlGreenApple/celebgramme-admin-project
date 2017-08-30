@extends('layout.main')

@section('content')
  <!-- Modal Add Email-->
	<div class="modal fade" id="modal-proxy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Add Data
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data" id="form-add">
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">File</label>
										<div class="col-sm-8 col-md-6">
											<input type="file" id="fileExcel" name="fileExcel" class="form-control"> 
										</div>
									</div>
								</form>
							</div>
							<div class="modal-footer">
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-add">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Phone
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	
	
  <div class="page-header">
    <h1>Phone Data</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="keyword"> 
    </div>
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add Phone Fullname" id="button-Add" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#modal-proxy" > 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Delete All" id="button-delete-all" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#confirm-delete" > 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Export" id="button-export-data" class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Download Template" id="button-download-template" class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No.</th>
        <th>Phone</th>
        <th>Fullname</th>
        <th></th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav>
    <ul class="pagination" id="pagination">
    </ul>
  </nav>  
  
  <div id="div-confirm">
  </div>
  
  <script>
      
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-phone-users'); ?>',
        type: 'get',
        data: {
          keyword : $("#search-text").val(),
          page: page,
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
        url: '<?php echo url('pagination-phone-users'); ?>',
        type: 'get',
        data: {
          keyword : $("#search-text").val(),
					page : page,
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#pagination').html(result);
          
          $('#pagination a').click(function(e){
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
    $(document).ready(function(){
      $("#alert").hide();
      refresh_page(1);
      create_pagination();
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination();
        refresh_page(1);
      });

      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-proxy-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-phone-users'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-delete").val(),
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              create_pagination(1);
              refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
      $( "body" ).on( "click", "#button-submit-add", function() {
				var uf = $('#form-add');
				var fd = new FormData(uf[0]);
				
        $.ajax({
          url: '<?php echo url('add-phone-users'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
					processData:false,
					contentType: false,
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
              create_pagination(1);
              refresh_page(1);
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
            } else if (data.type=='error') {
              $("#alert").addClass("alert-danger");
              $("#alert").removeClass("alert-success");
            }
						$("#div-loading").hide();
          }
        });
      });

			$( "body" ).on( "click", "#button-export-data", function() {
				window.location="<?php echo url('export-phone-users'); ?>";
      });
			
			$( "body" ).on( "click", "#button-download-template", function() {
				window.location="<?php echo url('download-template-email'); ?>";
      });
			
    });
  </script>		
  
@endsection
