@extends('layout.main')

@section('content')


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD Order</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-order">
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
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Package</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="select-auto-manage" id="select-auto-manage">
									<option value="None">-- Select --</option>
									<?php 
									  if ($packages_affiliate->count()>0) {
											foreach($packages_affiliate->get() as $package_affiliate){ ?>
												<option value="{{$package_affiliate->id}}">{{$package_affiliate->package_name." - Rp. ".number_format($package_affiliate->price,0,'','.')}}</option>
									<?php 
											}
											
										}
									?>
								</select>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Metode Pembayaran</label>
              <div class="col-sm-8 col-md-6">
								<select class="form-control" name="payment-method">
									<option value="1">Bank transfer</option>
									<!--<option value="2">Veritrans</option>-->
								</select>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Affiliate</label>
              <div class="col-sm-8 col-md-6">
								<input type="checkbox" name="affiliate-check" id="affiliate-check">
              </div>
            </div>  
            <input type="hidden" name="id-order" id="id-order">
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
									Delete Order
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-order-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	


  <div class="page-header">
    <h1>Order</h1>
  </div>  

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
        <th>Created</th>
        <th>No. order</th>
        <th>Email</th>
        <th>Fullname</th>
        <th>Total (Rp.)</th>
        <th>Package name</th>
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

    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-order'); ?>',
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
        url: '<?php echo url('pagination-order'); ?>',
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
      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-order-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-order'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-order-delete").val(),
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
        $("#id-order").val("new");
  			$('#affiliate-check').attr('checked', false);
				$("#select-auto-manage").val("None");
				$("#email").val("");
				$("#fullname").val("");
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $("#id-order").val($(this).attr("data-id"));
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
          data: $("#form-order").serialize(),
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
