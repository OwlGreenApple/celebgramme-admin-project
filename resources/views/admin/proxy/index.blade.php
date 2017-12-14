@extends('layout.main')

@section('content')
  <!-- Modal Add proxy using excel-->
  <div class="modal fade" id="myModalAddProxyUsingExcel" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Proxy Using Excel</h4>
        </div>
        <div class="modal-body">
					{!! Form::open(array('url'=>'','method'=>'POST', 'files'=>true, 'id'=>'form-add-proxy-using-excel')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="" name="fileExcel" class="form-control"> 
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-add-proxy-using-excel" data-check="auto">Submit</button>
        </div>
      </div>
    </div>
  </div>
	
  <!-- Modal replace proxy 2 data excel-->
  <div class="modal fade" id="myModalReplaceProxyUsingExcel" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Replace Proxy Using Excel</h4>
        </div>
        <div class="modal-body">
					{!! Form::open(array('url'=>'','method'=>'POST', 'files'=>true, 'id'=>'form-replace-proxy-using-excel')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="" name="fileExcel" class="form-control"> 
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-replace-proxy-using-excel" data-check="auto">Submit</button>
        </div>
      </div>
    </div>
  </div>
	

  <!-- Modal Check proxy error from excel-->
  <div class="modal fade" id="myModalCheckProxyUsingExcel" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Check Proxy from Excel Data</h4>
        </div>
        <div class="modal-body">
					{!! Form::open(array('url'=>'','method'=>'POST', 'files'=>true, 'id'=>'form-check-proxy-using-excel')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="" name="fileExcel" class="form-control"> 
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-check-proxy-using-excel" data-check="auto">Submit</button>
        </div>
      </div>
    </div>
  </div>
	

  <!-- Modal Add proxy-->
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
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Proxy Local</label>
										<div class="col-sm-8 col-md-6">
											<input type="checkbox" class="" name="is_local_proxy" id="is_local_proxy">
										</div>
									</div>
									<input type="hidden" class="" name="id_proxy" id="id-proxy">
								</form>
									
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-proxy">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
	
  <!-- Modal Check proxy-->
	<div class="modal fade" id="modal-check-proxy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Check Proxy
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data" id="form-check-proxy">
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Proxy</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="proxy" name="proxy" id="proxy-check">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Username password proxy</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="username:password" name="cred" id="cred-check">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Port</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="port" name="port" id="port-check">
										</div>
									</div>
								</form>
									
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-check-proxy">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
	
  <div class="modal fade" id="myModalAllError" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">All Proxy Error</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<p id="p-all-error" style="margin-left:10px;"></p>
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>
	

  <!-- Modal Check proxy-->
	<div class="modal fade" id="modal-exchange-proxy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Exchange Proxy
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data" id="form-exchange-proxy">
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="proxy-exchange">New Proxy</label>
										<div class="col-sm-12 col-md-12">
											<input type="text" class="form-control" placeholder="proxy" name="proxy" id="proxy-exchange">
										</div>
									</div><!--
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="cred-exchange">New Username password proxy</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="username:password" name="cred" id="cred-exchange">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="port-exchange">New Port</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="port" name="port" id="port-exchange">
										</div>
									</div>
									-->
									<input type="hidden" class="" name="id_proxy" id="id-proxy-exchange">
								</form>
									
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-exchange-proxy">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
	
	
  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Order
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-proxy-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	
	
  <div class="page-header">
    <h1>Proxy Manager</h1>
		<p>Free proxy : {{$numAvailableProxy}}</p>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="keyword"> 
    </div>
    <div class="input-group fl">
      <select id="proxy-show-data" class="form-control">
				<option value="1">
					All
				</option>
				<option value="0">
					Error
				</option>
      </select>
    </div>
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add" id="button-add" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#modal-proxy"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Check Proxy" id="button-check" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#modal-check-proxy" > 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Check All proxy" id="button-check-all" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalAllError" > 
    </div>  
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Add proxy excel" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalAddProxyUsingExcel" > 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Replace proxy excel" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalReplaceProxyUsingExcel" > 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Check proxy excel" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalCheckProxyUsingExcel" > 
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
        <th>Proxy</th>
        <th>Username & Password Proxy</th>
        <th>Port</th>
        <th>Count used</th>
        <th>Insta Username used</th>
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
        url: '<?php echo url('load-proxy-manager'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
          data_show : $("#proxy-show-data").val(),
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
        url: '<?php echo url('pagination-proxy-manager'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
					data_show : $("#proxy-show-data").val(),
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
      create_pagination(1);
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });

      $('#button-submit-check-proxy').click(function(e){
        $.ajax({
          url: '<?php echo url('check-proxy'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-check-proxy").serialize(),
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
      });
      $( "body" ).on( "click", ".button-edit-proxy", function() {
        $("#id-proxy").val($(this).attr("data-id"));
        $("#proxy").val($(this).attr("data-proxy")+":"+$(this).attr("data-port")+":"+$(this).attr("data-cred"));
        // $("#cred").val($(this).attr("data-cred"));
        // $("#port").val($(this).attr("data-port"));
      });
      $( "body" ).on( "click", "#button-submit-proxy", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('add-proxy'); ?>',
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
			
      $('#button-check-all').click(function(e){
        $.ajax({
          url: '<?php echo url('check-proxy-all'); ?>',
          type: 'get',
          data: {
						id : ""
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
							$("#p-all-error").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });
			
			
      $( "body" ).on( "click", ".btn-exchange-proxy", function() {
				$("#id-proxy-exchange").val($(this).attr("data-id"));
      });
      $('#button-submit-exchange-proxy').click(function(e){
        $.ajax({
          url: '<?php echo url('exchange-proxy'); ?>',
          type: 'get',
          data: $("#form-exchange-proxy").serialize(),
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
			
      $( "body" ).on( "click", "#btn-add-proxy-using-excel", function() {
					var uf = $('#form-add-proxy-using-excel');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('exchange-error-proxy'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
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
			
      $( "body" ).on( "click", "#btn-replace-proxy-using-excel", function() {
					var uf = $('#form-replace-proxy-using-excel');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('exchange-replace-proxy'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
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
			
      $( "body" ).on( "click", "#btn-check-proxy-using-excel", function() {
					var uf = $('#form-check-proxy-using-excel');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('check-proxy-excel'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
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
