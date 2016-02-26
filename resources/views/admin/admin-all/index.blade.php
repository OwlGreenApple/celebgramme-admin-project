@extends('layout.main')

@section('content')


  <div class="modal fade" id="myModalAutoManage" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Give times (auto manage)</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-give-auto">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Times(day)</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" class="form-control" placeholder="Jumlah hari yang ditambahkan" name="active-days" id="active-days">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Times(hour)</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" class="form-control" placeholder="Jumlah jam yang ditambahkan" name="active-hours" id="active-hours">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Times(minute)</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" class="form-control" placeholder="Jumlah menit yang ditambahkan" name="active-minutes" id="active-minutes">
              </div>
            </div>  
              <input type="hidden" class="user-id" name="user-id">
              <input type="hidden" class="action" name="action">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default button-process" data-dismiss="modal" id="" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="myModalCreateMember" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Admin</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-create-member">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Email</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Email" name="email" id="email">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Name</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Fullname" name="fullname" id="fullname">
              </div>
            </div>  
              <input type="hidden" class="user-id" name="user-id">
              <input type="hidden" class="action" name="action">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-create-member" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="myModalEditMember" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Admin</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-member">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Email</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Email" name="emailedit" id="emailedit">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Name</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Fullname" name="fullnameedit" id="fullnameedit">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">days</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" class="form-control" placeholder="Jumlah hari Auto Manage" name="member-days" id="member-days">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Color</label>
              <div class="col-sm-8 col-md-6">
                <input type="color" id="member-color"  value="#ff0000" style="width:85%;" name="member-color">
              </div>
            </div>  
              <input type="hidden" class="user-id" name="user-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-edit-member" data-check="auto">Submit</button>
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
							<input type="hidden" id="id-member-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	

  <div class="page-header">
    <h1>Admin all</h1>
  </div>  
  <p>
  </p>
  <div class="cover-input-group">
    <p>Sort By
    </p>
    <div class="input-group fl">
      <select class="form-control" id="sort-by">
				<option value="1"> Created </option>
				<option value="2"> Auto Manage </option>
      </select>
    </div>
    <div class="input-group fl">
			<input type="text" id="keyword-search" class="form-control" placeholder="Email">
    </div>
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add member" id="button-add-member" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalCreateMember" > 
    </div>  
		
    <div class="none"></div>
  </div>
	
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Email</th>
        <th>Name</th>
        <th>Times left (auto manage)</th>
        <th>Created</th>
        <th></th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-admin'); ?>',
        type: 'get',
        data: {
          page: page,
          sort: $("#sort-by").val(),
					keyword: $("#keyword-search").val(),
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
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
        url: '<?php echo url('pagination-admin'); ?>',
        type: 'get',
        data: {
          page : page,
          sort: $("#sort-by").val(),
					keyword: $("#keyword-search").val(),
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
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
    function give_bonus(formVar){
        $.ajax({                                      
          url: '<?php echo url('give-bonus'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: formVar,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              if(data.action=='auto') {
                $(".row"+data.id).find(".total-auto-manage").html(data.view);
              }
              if(data.action=='daily') {
                $(".row"+data.id).find(".total-balance").html(data.view);
              }
            }
            $("#div-loading").hide();
          }
        });
    }
    $(document).ready(function(){
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $(".user-id").val($(this).attr("data-id"));
        $("#emailedit").val($(this).attr("data-email"));
        $("#fullnameedit").val($(this).attr("data-nama"));
        $("#member-color").val($(this).attr("data-color"));
      });
      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-member-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-member-delete").val(),
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
      $( "body" ).on( "click", ".btn-auto-manage", function() {
        $(".user-id").val($(this).attr("data-id"));
        $(".action").val("auto");
        $("#active-days").val("");
      });
      $( "body" ).on( "click", ".button-process", function() {
        temp = $(this);
        if (temp.attr("data-check")=="auto") { formVar = $("#form-give-auto").serialize(); }
        if (temp.attr("data-check")=="daily") { formVar = $("#form-give-daily").serialize(); }
        
        
        give_bonus(formVar);
      });

      $( "body" ).on( "click", "#btn-create-member", function() {

        $.ajax({
          url: '<?php echo url('add-admin'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-create-member").serialize(),
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
							$("#select-order option[value='"+data.orderid+"']").remove();
            } else if (data.type=='error') {
              $("#alert").addClass("alert-danger");
              $("#alert").removeClass("alert-success");
            }
            $("#div-loading").hide();
          }
        });


      });

      $( "body" ).on( "click", "#btn-edit-member", function() {

        $.ajax({
          url: '<?php echo url('edit-admin'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-member").serialize(),
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
