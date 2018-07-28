@extends('layout.main')

@section('content')

  <div class="modal fade" id="myModalTimeLogs" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm" id="time-log-div">
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="myModalOrderPackage" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Order Package</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-order-package">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Package</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="package-auto-manage" id="select-auto-manage">
									<?php foreach($packages as $package) { ?>
										<option data-real="{{$package->price}}" data-price="{{number_format($package->price,0,'','.')}}" value="{{$package->id}}" >
										Paket {{$package->package_name." - Rp ".number_format($package->price,0,'','.')}}</option>
									<?php } ?>
								</select>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Coupon</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Code Coupon" name="coupon-code" id="coupon-code">
              </div>
            </div>  
            <input type="hidden" class="user-id" name="user-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-process-order" >Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="myModalDailyLikes" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Give daily likes</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-give-daily">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">days</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" class="form-control" placeholder="Jumlah like per hari yang ditambahkan" name="daily-likes" id="daily-likes">
              </div>
            </div>  
            <!--
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Valid until</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Valid sampai tanggal" name="valid-until" id="valid-until">
              </div>
            </div>  
          -->
            <input type="hidden" class="user-id" name="user-id">
            <input type="hidden" class="action" name="action">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default button-process" data-dismiss="modal" id="" data-check="daily">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

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
          <h4 class="modal-title">Add Member Affiliate</h4>
        </div>
        <div class="modal-body">
          <!--<form enctype="multipart/form-data" id="form-create-member">-->
					{!! Form::open(array('url'=>'save-confirmation','method'=>'POST', 'files'=>true, 'id'=>'form-create-member')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Type Input</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="select_input" id="select-input">
									<option value="manual">Manual</option>
									<option value="excel">Excel</option>
								</select>
              </div>
            </div>  
            <div class="form-group form-group-sm row type-manual">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Email</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Email" name="email" id="email">
              </div>
            </div>  
            <div class="form-group form-group-sm row type-manual">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Name</label>
              <div class="col-sm-8 col-md-6">
                <input type="text" class="form-control" placeholder="Fullname" name="fullname" id="fullname">
              </div>
            </div>  
            <div class="form-group form-group-sm row type-excel">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="fileExcel" name="fileExcel" class="form-control"> 
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Affiliate</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="select-affiliate" id="select-affiliate">
									<?php 
									  // if ($affiliates->count()>0) {
											foreach($affiliates as $affiliate){ ?>
												<option value="{{$affiliate->id}}">{{$affiliate->nama}} - free {{$affiliate->jumlah_hari_free_trial}} hari</option>
									<?php 
											}
											
										// }
									?>
								</select>
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
	
	
  <div class="modal fade" id="myModalBonusMember" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add BonusMember</h4>
        </div>
        <div class="modal-body">
					{!! Form::open(array('url'=>'save-bonus','method'=>'POST', 'files'=>true, 'id'=>'form-bonus-member')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Jumlah Hari</label>
              <div class="col-sm-8 col-md-6">
								<input type="number" id="jumlahHari" name="jumlahHari" class="form-control"> 
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="" name="fileExcel" class="form-control"> 
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-bonus-member" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
	
	
  <div class="modal fade" id="myModalAddRico" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Member Rico</h4>
        </div>
        <div class="modal-body">
					{!! Form::open(array('url'=>'add-member-rico','method'=>'POST', 'files'=>true, 'id'=>'form-add-rico')) !!}
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Jenis Paket</label>
              <div class="col-sm-8 col-md-6">
                <select class="form-control" name="package-rico" id="select-rico-package">
										<option value="195000" >Paket 195rb 3akun 1 bulan</option>
										<option value="395000" >Paket 395rb 3akun 3 bulan</option>
										<option value="449000" >Paket 449rb 6akun 3 bulan</option>
										<option value="695000" >Paket 695rb 3akun 6 bulan</option>
										<option value="799000" >Paket 799rb 6akun 6 bulan</option>
										<option value="1285000" >Paket 1285rb 3akun 12 bulan</option>
								</select>
								
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Excel</label>
              <div class="col-sm-8 col-md-6">
								<input type="file" id="" name="fileExcel" class="form-control"> 
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-add-rico" data-check="auto">Add</button>
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
          <h4 class="modal-title">Edit Member</h4>
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
              <input type="hidden" class="user-id" name="user-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-edit-member" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="myModalEditLoginWebsta" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login Webstame</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-login-webstame">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Source using</label>
              <div class="col-sm-8 col-md-6">
                <input type="radio" name="check-login" id="radio-login-standard" value="2">
								<label for="radio-login-standard">Login Check Username</label> <br>
                <input type="radio" name="check-login" id="radio-login-api" value="0">
								<label for="radio-login-api">Login Check Curl</label>
              </div>
            </div>  
            <input type="hidden" class="user-id" name="user-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-edit-login-webstame" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalMaxAccount" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Max Account</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-max-account">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Max account</label>
              <div class="col-sm-8 col-md-6">
                <input type="number" name="max-account-user" id="max-account-user" value="0">
              </div>
            </div>  
            <input type="hidden" class="user-id" name="user-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-edit-max-account" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
	
  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Member
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
    <h1>Member affiliate</h1>
  </div>  
  <p>Total waktu : 
    <?php 
        $days = floor($total_auto_manage / (60*60*24));
        $hours = floor(($total_auto_manage / (60*60)) % 24);
        $minutes = floor(($total_auto_manage / (60)) % 60);
        $seconds = floor($total_auto_manage  % 60);
        echo $days." days ".$hours." hours ".$minutes." minutes ".$seconds." seconds";
    ?>
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
		<?php if($user->email == "celebgramme.dev@gmail.com") { ?>
			<div class="input-group fl">
				<input type="button" value="Add member" id="" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalBonusMember" > 
			</div>  
			<div class="input-group fl">
				<input type="button" value="Add member(rico)" id="" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalAddRico" > 
			</div>  
			<div class="input-group fl">
				<input type="button" value="List member(rico)" data-loading-text="Loading..." class="btn btn-primary" id="button-list-member"> 
			</div>  
		<?php } ?>
	  <div class="jumlahuser" align="right">
      Jumlah user = <?php echo $total_user; ?>
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
				<!--
        <th>Balance (Daily Likes)</th>
        <th>Valid until (Daily Likes)</th>
        <th>Free trial (Daily Likes)</th>
				-->
        <th>Times left (auto manage)</th>
        <th>MAX Account</th>
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
        url: '<?php echo url('load-member-affiliate'); ?>',
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
          var data = jQuery.parseJSON(result);

          $('#content').html(data.view);
          $('#pagination').html(data.pagination);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-member-all'); ?>',
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
      //create_pagination(1);
      refresh_page(1);

      $(document).on('click', '#pagination a', function (e) {
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
        //create_pagination(page);
        refresh_page(page);
      });

      $( "body" ).on( "click", "#button-list-member", function() {
        window.location="<?php echo url('list-rico-excel'); ?>";
      });
			
      $('#button-search').click(function(e){
        e.preventDefault();
        //create_pagination(1);
        refresh_page(1);
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $(".user-id").val($(this).attr("data-id"));
        $("#emailedit").val($(this).attr("data-email"));
        $("#fullnameedit").val($(this).attr("data-nama"));
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
              //create_pagination(1);
              refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
			
      // $( "body" ).on( "click", ".btn-daily-like", function() {
        // $(".user-id").val($(this).attr("data-id"));
        // $(".action").val("daily");
        // $("#daily-likes").val("");
        // $("#valid-until").val("");
      // });
			
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

					var uf = $('#form-create-member');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('add-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          // data: $("#form-create-member").serialize(),
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
              //create_pagination(1);
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

			
      $( "body" ).on( "click", "#btn-bonus-member", function() {
					var uf = $('#form-bonus-member');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('bonus-member'); ?>',
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
              //create_pagination(1);
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
			
      $( "body" ).on( "click", "#btn-add-rico", function() {
					var uf = $('#form-add-rico');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('add-member-rico'); ?>',
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
              //create_pagination(1);
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
			
      $( "body" ).on( "click", "#btn-edit-member", function() {

        $.ajax({
          url: '<?php echo url('edit-member'); ?>',
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
              //create_pagination(1);
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

      $( "body" ).on( "click", ".btn-max-account", function() {
        $(".user-id").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", ".btn-check-login-websta", function() {
        $(".user-id").val($(this).attr("data-id"));
				if ($(this).attr("data-test")==1) {
					$("#radio-login-websta").prop("checked", true);
				}
				if ($(this).attr("data-test")==0) {
					$("#radio-login-api").prop("checked", true);
				}
      });
      $( "body" ).on( "click", "#btn-edit-login-webstame", function() {

        $.ajax({
          url: '<?php echo url('edit-member-login-webstame'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-login-webstame").serialize(),
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
              //create_pagination(1);
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

      $( "body" ).on( "click", "#btn-edit-max-account", function() {

        $.ajax({
          url: '<?php echo url('edit-member-max-account'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-max-account").serialize(),
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

			
      $( "body" ).on( "click", ".btn-order-package", function() {
				$(".user-id").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#btn-process-order", function() {
        $.ajax({                                      
          url: '<?php echo url('member-order-package'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
					data: $("#form-order-package").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              //create_pagination(1);
              refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
			
      
      $( "body" ).on( "click", ".btn-time-logs", function() {
        temp = $(this);
				$("#time-log-div").html("");
        $.ajax({                                      
          url: '<?php echo url('load-time-logs'); ?>',
          type: 'get',
          data: {
						id : $(this).attr("data-id")
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
							$("#time-log-div").html('<table class="table table-bordered table-data-default">  <thead>	<tr style="font-weight:bold;"><th>Date time</th><th>Sisa waktu</th></tr>      </thead><tbody id="p-logs"></tbody></table>  ');
							$("#p-logs").html(data.logs);
							$('.table-data-default').DataTable();
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });


			$(".type-excel").hide();
			$('#select-input').on('change', function() {
				// alert( this.value ); // or $(this).val()
				// alert( $(this).val() ); // or $(this).val()
				if ($(this).val()=="manual") {
					$(".type-manual").show();
					$(".type-excel").hide();
				}
				if ($(this).val()=="excel") {
					$(".type-manual").hide();
					$(".type-excel").show();
				}
			});			
			
    });
  </script>		
  
@endsection
