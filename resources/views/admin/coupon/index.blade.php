@extends('layout.main')

@section('content')


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Coupon</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-coupon">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Code</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon code" name="coupon_code" id="coupon_code">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Value</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon value" name="coupon_value" id="coupon_value">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Percentage</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon percent" name="coupon_percentage" id="coupon_percentage">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Package</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="coupon_package_id" id="coupon_package_id">
									<option value="0">all</option>
									<?php foreach($packages as $package){ ?>
										<option value="{{$package->id}}">{{$package->package_name." - Rp. ".number_format($package->price,0,'','.')}}</option>
									<?php } ?>
                </select>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Valid Until</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon valid until" name="valid_until" id="valid_until">
              </div>
            </div>  
            <input type="hidden" name="id-coupon" id="id-coupon">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-process">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="myModalSetting" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Coupon Expired Notification</h4>
        </div>
        <div class="modal-body">
					<?php 
						use Celebgramme\Models\Meta;
					?>
          <form enctype="multipart/form-data" id="form-setting-coupon">					
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Days</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Days" name="coupon_setting_days" value="{{Meta::getMeta('coupon_setting_days')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Value</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon value" name="coupon_setting_value" value="{{Meta::getMeta('coupon_setting_value')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon Percentage</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Coupon percent" name="coupon_setting_percentage" value="{{Meta::getMeta('coupon_setting_percentage')}}">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Package</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="coupon_setting_package_id" >
									<option value="0">all</option>
									<?php foreach($packages as $package){ ?>
										<option value="{{$package->id}}" <?php if (Meta::getMeta("coupon_setting_package_id")==$package->id) { echo "selected"; }  ?>>{{$package->package_name." - Rp. ".number_format($package->price,0,'','.')}}</option>
									<?php } ?>
                </select>
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-process-setting">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="page-header">
    <h1>Coupon</h1>
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
    <div class="input-group fl">
      <input type="button" value="Setting" id="button-setting" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalSetting"> 
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
        <th>Coupon code</th>
        <th>Coupon Value</th>
        <th>Coupon Percentage</th>
        <th>Coupon Package</th>
        <th>Valid Until</th>
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
        url: '<?php echo url('load-coupon'); ?>',
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
        url: '<?php echo url('pagination-coupon'); ?>',
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
        $("#id-coupon").val("new");
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $("#id-coupon").val($(this).attr("data-id"));
        $("#coupon_code").val($(this).attr("data-coupon-code"));
        $("#coupon_value").val($(this).attr("data-coupon-value"));
        $("#valid_until").val($(this).attr("data-valid-until"));
        $("#coupon_percentage").val($(this).attr("data-coupon-percent"));
        $("#coupon_package_id").val($(this).attr("data-package-id"));
      });
      $( "body" ).on( "click", "#button-process", function() {
        temp = $(this);
        $('#valid_until').val($('#valid_until').datepicker('getDate').getTime()/1000+(3600*24+1));
        $.ajax({                                      
          url: '<?php echo url('process-coupon'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-coupon").serialize(),
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
      $( "body" ).on( "click", "#button-process-setting", function() {
        $.ajax({                                      
          url: '<?php echo url('process-setting-coupon'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-setting-coupon").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
            }
            $("#div-loading").hide();
          }
        });
      });
      
    });
  </script>		
  
@endsection
