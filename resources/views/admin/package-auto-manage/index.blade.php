@extends('layout.main')

@section('content')


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD Package</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-auto-manage">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Package Name</label>
              <div class="col-sm-8 col-md-6">
								<input type="text" class="form-control" placeholder="Nama Paket" name="packagename" id="packagename">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Price (Rp.)</label>
              <div class="col-sm-8 col-md-6">
								<input type="number" class="form-control" placeholder="Harga paket tersebut" name="price" id="price">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Active Days</label>
              <div class="col-sm-8 col-md-6">
								<input type="number" class="form-control" placeholder="Jumlah hari yang ditambahkan" name="active-days" id="active-days">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Affiliate</label>
              <div class="col-sm-8 col-md-6">
								<input type="checkbox" name="affiliate-check" id="affiliate-check">
              </div>
            </div>  
            <input type="hidden" name="id-package" id="id-package">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-process">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Package
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-package-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	


  <div class="page-header">
    <h1>Package Auto Manage</h1>
  </div>  
  <!--
  <p></p>
  <div class="cover-input-group">
    <p>Filter tanggal 
    </p>
    <div class="input-group fl">
      <input type="text" id="from" class="form-control"> 
    </div>
    <div class="input-group fl">
      <p>hingga</p>
    </div>
    <div class="input-group fl">
      <input type="text" id="to" class="form-control"> 
    </div>  
    <div class="none"></div>
  </div>
  -->
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Add" id="button-add" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModal" > 
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
        <th>Package Name</th>
        <th>Price (Rp.)</th>
        <th>Active Days</th>
        <th>Affiliate</th>
        <th></th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  <script>
    $(function() {
      $("#valid_until").datepicker({
        dateFormat: 'dd-mm-yy',
      });

      $("#from").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(d) {
          var from = $('#from').datepicker('getDate');
          var to = $('#to').datepicker('getDate');
          if (from.getTime() > to.getTime()){
            $("#from").datepicker('setDate', to);
          }
        }
      });
      $("#to").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(d) {
          var from = $('#from').datepicker('getDate');
          var to = $('#to').datepicker('getDate');
          if (from.getTime() > to.getTime()){
            $("#to").datepicker('setDate', from);
          }
        }
      });
      $("#from").datepicker('setDate', new Date());
      $("#to").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-package-auto-manage'); ?>',
        type: 'get',
        data: {
          page: page,
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
        url: '<?php echo url('pagination-package-auto-manage'); ?>',
        type: 'get',
        data: {
          page : page,
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
    $(document).ready(function(){
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);
      $('#button-add').click(function(e){
        e.preventDefault();
        $("#packagename").val("");
        $("#price").val("");
        $("#active-days").val("");
				$('#affiliate-check').attr('checked', false);
        $("#id-package").val("new");
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $("#id-package").val($(this).attr("data-id"));
        $("#packagename").val($(this).attr("data-package-name"));
        $("#price").val($(this).attr("data-price"));
        $("#active-days").val($(this).attr("data-active-days"));
				if ( $(this).attr("data-affiliate") == "0") {
					$('#affiliate-check').attr('checked', false);
				} else {
					$('#affiliate-check').attr('checked', true);
				}
      });
      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-package-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-package-auto-manage'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-package-delete").val(),
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
      $( "body" ).on( "click", "#button-process", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('add-package-auto-manage'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-auto-manage").serialize(),
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
      
    });
  </script>		
  
@endsection
