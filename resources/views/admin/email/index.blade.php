@extends('layout.main')

@section('content')
  <!-- Modal Add Email-->
	<div class="modal fade" id="modal-proxy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Add / Edit Proxy
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data" id="form-proxy">
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Proxy</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="proxy" name="proxy" id="proxy">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Username password proxy</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="username:password" name="cred" id="cred">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Port</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="port" name="port" id="port">
										</div>
									</div>
									<input type="hidden" class="proxy-id" name="proxy-id">
								</form>
									
							</div>
							<input type="hidden" id="id-order-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-proxy">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Email
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-member-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	
	
  <div class="page-header">
    <h1>Email User</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="keyword"> 
    </div>
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add" id="button-Add" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#modal-proxy" disabled> 
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
        <th>Email</th>
        <th>Fullname</th>
        <th>Created</th>
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
        url: '<?php echo url('load-email-users'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
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
        url: '<?php echo url('pagination-email-users'); ?>',
        type: 'get',
        data: {
					page : page,
          search : $("#search-text").val(),
          username : $("#username").val(),
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
          url: '<?php echo url('delete-proxy'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-proxy-delete").val(),
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
      $('#button-add').click(function(e){
        e.preventDefault();
        $("#id-proxy").val("new");
  			$('#affiliate-check').attr('checked', false);
				$("#select-auto-manage").val("None");
				$("#email").val("");
				$("#fullname").val("");
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $("#id-proxy").val($(this).attr("data-id"));
				if ($(this).attr("data-package-manage-id") != 0 ) {
					$("#select-auto-manage").val($(this).attr("data-package-manage-id"));
				} else {
					$("#select-auto-manage").val("None");
				}
        $("#total").val($(this).attr("data-total"));
				if ( $(this).attr("data-affiliate") == "0") {
					$('#affiliate-check').attr('checked', false);
				} else {
					$('#affiliate-check').attr('checked', true);
				}
				$("#email").val($(this).attr("data-email"));
				$("#fullname").val($(this).attr("data-fullname"));
      });
      $( "body" ).on( "click", "#button-process", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('add-order'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-proxy").serialize(),
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

    });
  </script>		
  
@endsection
