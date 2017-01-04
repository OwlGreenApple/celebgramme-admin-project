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


  <div class="modal fade" id="myModalSettingLogs" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>Date time</th>
									<th>Activity</th>
								</tr>      
							</thead>
							<tbody id="p-setting-logs">
							</tbody>
						</table>  
						
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="myModalIdentity" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Identity IG account</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-identity">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Identity</label>
              <div class="col-sm-8 col-md-6">
								<textarea class="selectize-default" id="textarea-identity" name="identity"></textarea>
              </div>
              <input type="hidden" class="setting-id" name="setting-id">
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-identity">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalTarget" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Target IG account</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-target">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Target</label>
              <div class="col-sm-8 col-md-6">
								<textarea class="selectize-default" id="textarea-target" name="target"></textarea>
              </div>
              <input type="hidden" class="setting-id" name="setting-id">
            </div>  
          </form>
        </div>
        <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-target">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalLog" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<p id="p-logs" style="margin-left:10px;"></p>
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>
	
	
  <div class="modal fade" id="myModalDaily" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs Daily</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>Date time</th>
									<th>Unfollows counter</th>
									<th>Follows counter</th>
									<th>Likes Counter</th>
									<th>Comments Counter</th>
								</tr>      
							</thead>
							<tbody id="p-logs-daily">
							</tbody>
							
						</table>  
						
						
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalHourly" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs Hourly</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>Date time</th>
									<th>Unfollows counter</th>
									<th>Follows counter</th>
									<th>Likes Counter</th>
									<th>Comments Counter</th>
								</tr>      
							</thead>
							<tbody id="p-logs-hourly">
							</tbody>
							
						</table>  
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalErrorIG" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">IG Account error</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>IG ACCOUNT</th>
									<th>Status Cookies</th>
									<th>Description</th>
								</tr>      
							</thead>
							<tbody id="p-logs-errorIG">
							</tbody>
							
						</table>  
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>
	

	
  <div class="page-header">
    <h1>ALL Setting IG Automation</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
			<input type="text" id="keyword-search" class="form-control" placeholder="insta username" value="{{$search}}">
		</div>  
		<!--
    <div class="input-group fl">
			<select class="form-control" id="file-name">
				<option value="all">All</option>
				<option value="-">-</option>
			</select>
		</div>  
		-->
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="IG account error" id="button-show-error" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#myModalErrorIG"> 
    </div>  
    <div class="input-group fl">
			<select id="select-server">
				<option value="0">All</option>
				<option value="A1(automation-1)">A1(automation-1)</option>
				<option value="A2(automation-2)">A2(automation-2)</option>
				<option value="A3(automation-3)">A3(automation-3)</option>
				<option value="A5(automation-5)">A5(automation-5)</option>
				<option value="AA1(automation-1)">AA1(automation-1)</option>
				<option value="AA2(automation-2)">AA2(automation-2)</option>
				<option value="AA3(automation-3)">AA3(automation-3)</option>
			</select>
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
				<th>Password Error</th>
        <th>Insta username / Fullname (email) / start time</th>
        <th>Identity Categories</th>
        <th>Target Categories</th>
        <th>Followers</th>
        <th>Following</th>
        <th>Proxy</th>
				
        <th>Status </th>
        <th>Logs</th>
				
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
        url: '<?php echo url('load-automation'); ?>',
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
        url: '<?php echo url('pagination-automation'); ?>',
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
				persist: false,
				delimiter: ';',
				options: [
					<?php echo $strCategory; ?>
				],
				optgroups: [
					<?php echo $strClassCategory; ?>
				],
				optgroupField: 'class',
				labelField: 'name',
				searchField: ['name'],
				render: {
						optgroup_header: function(data, escape) {
								return '<div class="optgroup-header" style="font-size:16px;">' + escape(data.label) + '</div>';
						}
				},
				plugins:['remove_button']

			});
    }
    $(document).ready(function(){
			
			
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);
			
			refreshSelectize();
			

			$('#button-edit-identity').click(function(e){
				settingId = $(".setting-id").val();
        $.ajax({
          url: '<?php echo url('update-identity'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-identity").serialize(),
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
							
							//update data 
							$(".setting-id"+settingId).find(".edit-identity").html(data.identity);
							$(".setting-id"+settingId).find(".btn-identity-edit").attr("data-identity",data.identity);
            }
            $("#div-loading").hide();
          }
        });
			});
			
			$('#button-edit-target').click(function(e){
				settingId = $(".setting-id").val();
        $.ajax({
          url: '<?php echo url('update-target'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-target").serialize(),
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

							//update data 
							$(".setting-id"+settingId).find(".edit-target").html(data.target);
							$(".setting-id"+settingId).find(".btn-target-edit").attr("data-value-target",data.target);
            }
            $("#div-loading").hide();
          }
        });
			});
			
			$( "body" ).on( "click", ".btn-identity-edit", function() {
				$(".setting-id").val($(this).attr("data-id"));
				// fetch the instance
				var selectize = selectS[0].selectize;
				selectize.destroy();
				var selectize = selectS[1].selectize;
				selectize.destroy();
				$("#textarea-identity").val($(this).attr("data-identity"));
				refreshSelectize();
			});

			$( "body" ).on( "click", ".btn-target-edit", function() {
				$(".setting-id").val($(this).attr("data-id"));
				var selectize = selectS[0].selectize;
				selectize.destroy();
				var selectize = selectS[1].selectize;
				selectize.destroy();
				$("#textarea-target").val($(this).attr("data-value-target"));
				refreshSelectize();
			});

      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });
			
			
      $( "body" ).on( "click", ".btn-show-log", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs'); ?>',
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
							$("#p-logs").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", ".btn-show-log-daily", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs-daily'); ?>',
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
							$("#p-logs-daily").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", ".btn-show-log-hourly", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs-hourly'); ?>',
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
							$("#p-logs-hourly").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", "#button-show-error", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs-error'); ?>',
          type: 'get',
          data: {
						id : $(this).attr("data-id"),
						server : $("#select-server").val(),
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
							$("#p-logs-errorIG").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });
			
      $( "body" ).on( "click", ".btn-refresh-account", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('refresh-automation-IG-account'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
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
							alert("account berhasil direfresh");
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

      $( "body" ).on( "click", ".update-error", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-error-cred'); ?>/'+$(this).attr('data-id'),
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'patch',
          data: {
            _method : "PATCH",
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if (result=='success') {
              temp.removeClass('x-icon');
              temp.addClass('checked-icon');
            }
            $("#div-loading").hide();
          }
        });
      });
			
			
      $( "body" ).on( "click", ".btn-refresh-auth", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('refresh-auth-IG-account'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
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
							alert("auth account berhasil direfresh");
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });
			
      $( "body" ).on( "click", ".btn-show-log-settings", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-setting-logs'); ?>',
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
							$("#p-setting-logs").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", ".btn-delete-action", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('delete-action-IG-account'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
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
							alert("account berhasil direfresh & action log dihapus");
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
    });
  </script>		
  
@endsection
