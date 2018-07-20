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
  <div class="modal fade" id="myModalSettingLogs" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm" id="setting-log-div">
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





  <div class="modal fade" id="myModalEditAutomationMethod" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Automation Method</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-method-automation">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Automation using</label>
              <div class="col-sm-8 col-md-6">
                <input type="radio" name="method-automation" id="radio-automation-API" value="API">
								<label for="radio-automation-API">API</label> <br>
                <input type="radio" name="method-automation" id="radio-automation-CURL" value="CURL">
								<label for="radio-automation-CURL">CURL</label>
              </div>
            </div>  
            <input type="hidden" class="setting-id" name="setting-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-edit-method-automation" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
	
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Server Name</label>
              <div class="col-sm-8 col-md-6">
								<select class="form-control" name="fl-filename" id="fl-filename">
									@foreach ($filenames as $filename)
										<option value="{{$filename->meta_value}}">{{$filename->meta_value}}</option>
									@endforeach
								</select>
								<!--
                <input type="text" class="form-control" placeholder="Input follow liker filename" name="fl-filename" id="fl-filename">
								-->
              </div>
              <input type="hidden" id="setting-id" name="setting-id">
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-filename">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Modal Server Automation-->
  <div class="modal fade" id="serverAutomationModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-server-automation">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Server Automation Name</label>
              <div class="col-sm-8 col-md-6">
								<select class="form-control" name="server-automation" id="server-automation">
									@foreach ($filenames as $filename)
										<option value="{{$filename->meta_value}}">{{$filename->meta_value}}</option>
									@endforeach
								</select>
              </div>
              <input type="hidden" class="setting-id" name="setting-id">
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-server-automation">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Modal Email to user-->
  <div class="modal fade" id="myModalSendEmail" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Email</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-send-email">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Template</label>
              <div class="col-sm-8 col-md-6">
								<select class="form-control" id="select-send-email">
								@foreach ($templates as $template)
									<option value="{{$template->id}}">{{$template->name}}</option>
								@endforeach
								</select>
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Title</label>
              <div class="col-sm-8 col-md-6">
								<input type="text" class="form-control" name="title-email" id="title-email">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Message</label>
              <div class="col-sm-8 col-md-6">
								<textarea class="form-control" name="message-email" id="message-email" style="height:180px; width:270px;"></textarea>
              </div>
            </div>  
						<input type="hidden" id="sender" name="sender">
						<input type="hidden" id="fullname" name="fullname">
						<input type="hidden" id="igaccount" name="igaccount">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-send-email">Send</button>
        </div>
      </div>
      
    </div>
  </div>
	
	<!-- Modal Automation -->
  <div class="modal fade" id="myModalAutomation" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-setting-proxy">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Proxy</label>
              <div class="col-sm-8 col-md-6 ui-widget">
                <input type="text" class="form-control" placeholder="proxy" name="proxy" id="proxy">
                <input type="hidden" name="hiddenIdProxy" id="hiddenIdProxy">
              </div>
            </div>
            <input type="hidden" class="setting-id" name="setting-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default button-process" data-dismiss="modal" id="button-process-setting-proxy" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

	<!-- Modal Method Automation ( AUTO / MANUAL) -->
  <div class="modal fade" id="myModalMethodAutomation" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-setting-method-automation">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Pilih method</label>
              <div class="col-sm-8 col-md-6 ui-widget">
                <input type="radio" class="" name="radio_method_automation" id="manual-automation" value="manual">
								<label for="manual-automation">Manual (Spiderman)</label> <br>
                <input type="radio" class="" name="radio_method_automation" id="auto-automation" value="auto">
								<label for="auto-automation">Auto (Auto New) </label>
              </div>
            </div>
            <input type="hidden" class="setting-id" name="setting-id">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default button-process" data-dismiss="modal" id="button-process-method-automation" data-check="auto">Submit</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="page-header">
    <h1>ALL Setting IG account</h1>
  </div>  
	<div class="row">
		<div class="col-md-1">
			<label>Server Status :</label>
		</div>
		<div class="col-md-2">
			<select class="form-control" id="status-server">
				<option value="normal" <?php if($status_server=="normal") { echo "selected"; } ?>>Normal</option>
				<option value="high" <?php if($status_server=="high") { echo "selected"; } ?>>High</option>
				<option value="maintenance" <?php if($status_server=="maintenance") { echo "selected"; } ?>>Maintenance</option>
			</select>
		</div>
		<div class="col-md-2">
			<input type="button" value="Update" id="button-server" data-loading-text="Loading..." class="btn btn-primary"> 
		</div>
	</div>
	<br>
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
        <th>Fullname (email) / Insta username / Insta password / start time</th>
        <!--<th>Method Automation</th>-->
        <th>Updates</th>
				
        <!--<th>Download </th>-->
        <th>Proxy</th>
        <th>Server Automation / Server Liker AutoLike</th>
        <th>Followers</th>
        <th>Following</th>
        <th>Status</th>
        <th></th>
				
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination2">
  </nav>  
	
  <div class="cover-input-group">
	  *buat copas ke keywords type (Relevant,)
    <div class="input-group fl">
    </div>  
	</div>  
  <div class="cover-input-group">
    <div class="input-group fl">
			<input type="text" class="form-control" placeholder="Keywords" id="keywords-excel">
    </div>  
    <div class="input-group fl">
			<input type="text" class="form-control" id="keywords-by" placeholder="Keywords type">
    </div>  
    <div class="input-group fl">
      <input type="button" value="Convert to excel" id="button-excel" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
  </div>  
	
  
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-setting'); ?>',
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
          var data = jQuery.parseJSON(result);
          console.log(data.view);
          $('#content').html(data.view);
          $('#pagination1').html(data.pagination);
          $('#pagination2').html(data.pagination);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-setting'); ?>',
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
        
          // $("#div-loading").hide();
        }
      });
    }
    $(document).ready(function(){
			
			//autocomplete proxy
			availableProxy =  <?php echo json_encode( $availableProxy ) ?>;
			console.log(availableProxy);

		  $('#proxy').autocomplete({
					source: availableProxy,
					select: function (event, ui) {
							$("#hiddenIdProxy").val(ui.item.id); // display the selected text
					}
			});			
			
      $("#alert").hide();
      //create_pagination(1);
      refresh_page(1);
			
      $(document).on('click', '#pagination1 a', function (e) {
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
          
      $(document).on('click', '#pagination2 a', function (e) {
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

			$( "body" ).on( "click", ".download-hashtags", function() {
				window.location="<?php echo url('download-hashtags'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find("select option:selected").attr("data-val");
      });
			$( "body" ).on( "click", ".download-usernames", function() {
				window.location="<?php echo url('download-usernames'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find(".select-username option:selected").html();
      });
			$( "body" ).on( "click", ".download-comments", function() {
				window.location="<?php echo url('download-comments'); ?>/"+$(this).attr("data-id");
      });
			
			
      $('#button-server').click(function(e){
        $.ajax({                                      
          url: '<?php echo url('update-status-server'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
            statusServer :$("#status-server").val(),
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if (result=='success') {
							alert("Status server berhasil diubah");
            }
            $("#div-loading").hide();
          }
        });
      });
			
      $('#button-excel').click(function(e){
        e.preventDefault();
        window.location="<?php echo url('create-excel'); ?>/"+$("#keywords-excel").val()+"/"+$("#keywords-by").val();
      });
      $('#button-search').click(function(e){
        e.preventDefault();
        //create_pagination(1);
        refresh_page(1);
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
      $( "body" ).on( "click", ".update-status", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-auto-manage'); ?>/'+$(this).attr('data-id'),
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
      
			$( "body" ).on( "click", ".see-update", function(e) {
				e.preventDefault();
				$(this).siblings('.data-updates').slideToggle();
			});
			$( "body" ).on( "click", ".see-all", function(e) {
				e.preventDefault();
				$(this).siblings('.data-all').slideToggle();
			});
			
      $( "body" ).on( "click", ".btn-fl-edit", function() {
				$("#setting-id").val($(this).attr("data-id"));
				$("#fl-filename").val($(this).attr("data-filename"));
			});
      $( "body" ).on( "click", "#button-edit-filename", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-fl-filename'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              $(".row"+data.id).find(".fl-filename").find(".edit-fl-filename").html(data.filename);
              $(".row"+data.id).find(".fl-filename").find(".glyphicon").attr("data-filename" , data.filename);
            }
            $("#div-loading").hide();
          }
        });
      });
      $( "body" ).on( "click", ".btn-server-automation-edit", function() {
				$(".setting-id").val($(this).attr("data-id"));
				$("#server-automation").val($(this).attr("data-filename"));
			});
      $( "body" ).on( "click", "#button-server-automation", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-server-automation'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-server-automation").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              $(".row"+data.id).find(".server-automation-name").find(".edit-server-automation").html(data.servername);
              $(".row"+data.id).find(".server-automation-name").find(".glyphicon").attr("data-filename" , data.servername);
            }
            $("#div-loading").hide();
          }
        });
      });
			$( "body" ).on( "click", ".btn-send-email", function() {
				$("#sender").val($(this).attr("data-email"));
				$("#fullname").val($(this).attr("data-fullname"));
				$("#igaccount").val($(this).attr("data-igaccount"));
				$('#select-send-email').change();
      });
      $( "body" ).on( "click", "#button-send-email", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('send-email-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-send-email").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if(result=='success') {
            }
            $("#div-loading").hide();
          }
        });
      });

			$( "body" ).on( "click", ".button-setting-proxy", function() {
				$(".setting-id").val($(this).attr("data-id"));
        $.ajax({
          url: '<?php echo url('get-proxy-data'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'get',
          data: {
            id :$(this).attr("data-id"),
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            // alert(result);
						$("#proxy").val(result);
						$("#div-loading").hide();
          }
        });
      });
			$( "body" ).on( "click", ".button-show-server_automation", function() {
				$(".setting-id").val($(this).attr("data-id"));
        $.ajax({
          url: '<?php echo url('get-server-automation'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'get',
          data: {
            id :$(this).attr("data-id"),
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            alert(result);
						$("#div-loading").hide();
          }
        });
      });
			$( "body" ).on( "click", ".button-show-cookies", function() {
				$(".setting-id").val($(this).attr("data-id"));
        $.ajax({
          url: '<?php echo url('get-cookies-automation'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'get',
          data: {
            id :$(this).attr("data-id"),
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            alert(result);
						$("#div-loading").hide();
          }
        });
      });
      $( "body" ).on( "click", "#button-process-setting-proxy", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('update-setting-proxy'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-setting-proxy").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
						var data = jQuery.parseJSON(result);
            if(data.message=='success') {
							// create_pagination(1);
							// refresh_page(1);
							console.log(data.id+" "+data.proxy);
							$(".table .row"+data.id+" .setting-proxy :button").attr("data-proxy",data.proxy);
            }
						// console.log(result);
            $("#div-loading").hide();
          }
        });
      });

			$('#select-send-email').on('change', function() {
				// alert( this.value ); // or 
				temp_id = this.value;
        $.ajax({
          url: "<?php echo url('load-template'); ?>",
          type: 'get',
          data: {
						id :temp_id,
						name:$("#fullname").val(),
						igaccount:$("#igaccount").val(),
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
							$("#title-email").val(data.title);
							$("#message-email").html(data.message);
            }
            $("#div-loading").hide();
          }
        });
			});
			
			//method automation (MANUAL or AUTO)
			$( "body" ).on( "click", ".button-method", function() {
				$(".setting-id").val($(this).attr("data-id"));
				if ($(this).attr("data-automation")== "yes") {
					$("#auto-automation").prop('checked', true);
				} else {
					$("#manual-automation").prop('checked', true);
				}
			});
      $( "body" ).on( "click", "#button-process-method-automation", function() {
        temp = $(this);
        $.ajax({
          url: '<?php echo url('update-method-automation'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-setting-method-automation").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if(result=='success') {
							//create_pagination(1);
							refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });

      $( "body" ).on( "click", ".btn-check-method-automation", function() {
        $(".setting-id").val($(this).attr("data-id"));
				$("#radio-automation-API").prop("checked", false);
				$("#radio-automation-CURL").prop("checked", false);
				if ($(this).attr("data-method")=="API") {
					$("#radio-automation-API").prop("checked", true);
				}
				if ($(this).attr("data-method")=="CURL") {
					$("#radio-automation-CURL").prop("checked", true);
				}
      });
			
      $( "body" ).on( "click", "#btn-edit-method-automation", function() {

        $.ajax({
          url: '<?php echo url('edit-method-automation'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-method-automation").serialize(),
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
			
      $( "body" ).on( "click", ".btn-show-log-settings", function() {
        temp = $(this);
				$("#setting-log-div").html("");
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
							$("#setting-log-div").html('<table class="table table-bordered table-data-default"><thead><tr style="font-weight:bold;"><th>Date time</th><th>Activity</th></tr></thead><tbody id="p-setting-logs"></tbody></table>');
							$("#p-setting-logs").html(data.logs);
							$('.table-data-default').DataTable();
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
			
      $( "body" ).on( "click", ".btn-start", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('start-account'); ?>',
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
			
    });
  </script>		
  
@endsection
