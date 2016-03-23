@extends('layout.main')

@section('content')
<style>
	.wrap{
		// white-space: pre-wrap;      /* CSS3 */   
		// white-space: -moz-pre-wrap; /* Firefox */    
		// white-space: -pre-wrap;     /* Opera <7 */   
		// white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */		
		width:350px;
	}
</style>

  <!-- Modal confirmation-->
	<div class="modal fade" id="confirm-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Confirmation Box
							</div>
							<div class="modal-body">
									Are you sure want to this ?
							</div>
							<input type="hidden" id="id-order-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-yes" data-action="">Yes</button>
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
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Spiderman filename</label>
              <div class="col-sm-8 col-md-6">
								<select class="form-control" name="fl-filename" id="fl-filename">
									@foreach ($filenames as $filename)
										<option value="{{$filename->meta_value}}">{{$filename->meta_value}}</option>
									@endforeach
								</select>
								<!--
                <input type="text" class="form-control" placeholder="Input follow spiderman filename" name="fl-filename" id="fl-filename">
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
						<input type="hidden" id="settingid" >
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-send-email">Send</button>
        </div>
      </div>
      
    </div>
  </div>
	

  <div class="page-header">
    <h1>History Posts</h1>
  </div>  
  <p>	
	* unfollow_wdfm = unfollow who dont follow me <br>
	dont_follow_su = dont follow same user <br>
	dont_follow_pu = dont follow private user <br>
	dont_comment_su = dont comment same user <br>
	usernames_whitelist = usernames unfollow whitelist <br>
	C1 : \\23.250.113.28\Users\Administrator\Documents\Follow Liker\import <br>
	C2 : \\198.52.129.10\Users\Administrator\Documents\Follow Liker\import <br>
	C3 : \\104.254.93.39\Users\Administrator\Documents\Follow Liker\import <br>
	<br>	
	<span style="color:#4fee57"><strong>*Online</strong></span> = Last seen < 10 minutes
	
	</p>
	<!--
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
    <div class="input-group fl">
			<input type="text" id="keyword-search" class="form-control" placeholder="insta username">
		</div>  
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>
  -->
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
	<?php 
		$online = "Online : ";
		use Celebgramme\Models\SettingMeta; 
		use Celebgramme\Models\UserMeta; 
		
		$now = Carbon::now();
		
		foreach($admin as $ad){
			$usercolor = UserMeta::getMeta($ad->id,"color");
			$last_seen = Carbon::createFromFormat('Y-m-d H:i:s', $ad->last_seen)->addMinutes(10);
			// if ($ad->last_seen <= $now->addMinutes(10) ) {
			if ($last_seen->gt($now)) {
			// $usermeta = UserMeta::getMeta($ad->id,"login");
			// if ($usermeta=="yes"){
				$online .= "<span style='font-weight:Bold;color:".$usercolor.";'>".$ad->fullname."</span> &nbsp";
			}
		}
	?>
	<p align="right"><?php echo $online; ?> Total Setting Post yang perlu di update : <span style="font-size:48px;font-weight:Bold;color:#c12e2a;" id="update-post">{{$count_post}}</span></p>
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Taken By username</th>
        <th>Filename (spiderman)</th>
        <th>Password Error</th>
        <th>Insta username</th>
        <th>Insta password</th>
        <th>Fullname(Email)</th>
        <th>Updates</th>
        <th>Update terakhir</th>
        <!--<th>Download All setting</th>-->
        <th>Download Hashtags</th>
        <th>Download Usernames</th>
        <th>Download Comments</th>
        <th>Status</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
	
  <div class="cover-input-group">
	  *buat copas ke keywords type (Relevant, Normal Search, User's Follower, User's Following, User's Photo)
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
			<input type="text" class="form-control" id="keywords-username" placeholder="Username">
    </div>  
    <div class="input-group fl">
      <input type="button" value="Convert to excel" id="button-excel" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
  </div>  
	
  
  <script>
    // $(function() {
      // $("#from").datepicker({
        // dateFormat: 'dd-mm-yy',
        // onSelect: function(d) {
          // var from = $('#from').datepicker('getDate');
          // var to = $('#to').datepicker('getDate');
          // if (from.getTime() > to.getTime()){
            // $("#from").datepicker('setDate', to);
          // }
        // }
      // });
      // $("#to").datepicker({
        // dateFormat: 'dd-mm-yy',
        // onSelect: function(d) {
          // var from = $('#from').datepicker('getDate');
          // var to = $('#to').datepicker('getDate');
          // if (from.getTime() > to.getTime()){
            // $("#to").datepicker('setDate', from);
          // }
        // }
      // });
      // $("#from").datepicker('setDate', new Date());
      // $("#to").datepicker('setDate', new Date());
    // });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-post-auto-manage'); ?>',
        type: 'get',
        data: {
          page: page,
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
					keyword: $("#keyword-search").val(),
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
        url: '<?php echo url('pagination-post-auto-manage'); ?>',
        type: 'get',
        data: {
          page : page,
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
					keyword: $("#keyword-search").val(),
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
			
			var timeoutId = setTimeout(function(){
				 // window.location.reload(1);
				create_pagination(1);
				refresh_page(1);
			}, 30000);			
			
			$( "body" ).on( "click", ".download-all", function() {
				window.location="<?php echo url('download-all'); ?>/"+$(this).attr("data-id");
      });
			$( "body" ).on( "click", ".download-hashtags", function() {
				window.location="<?php echo url('download-hashtags'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find("select option:selected").attr("data-val");
      });
			$( "body" ).on( "click", ".download-usernames", function() {
				window.location="<?php echo url('download-usernames'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find("select option:selected").html();
      });
			$( "body" ).on( "click", ".download-comments", function() {
				window.location="<?php echo url('download-comments'); ?>/"+$(this).attr("data-id");
      });
			
      $('#button-excel').click(function(e){
        e.preventDefault();
				if ($("#keywords-by").val()=="") {
					temp_str="-";
				} else {
					temp_str=$("#keywords-by").val();
				}
        window.location="<?php echo url('create-excel'); ?>/"+$("#keywords-excel").val()+"/"+temp_str+"/"+$("#keywords-username").val();
      });
      // $('#button-search').click(function(e){
        // e.preventDefault();
        // create_pagination(1);
        // refresh_page(1);
      // });

      $('#button-yes').click(function(e){
				if ($(this).attr('data-action')=="update-error") {
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
								temp_update_error.removeClass('x-icon');
								temp_update_error.addClass('checked-icon');
							}
							$("#div-loading").hide();
						}
					});
					
				}
				if ($(this).attr('data-action')=="update-status") {
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
								// temp_update_status.removeClass('x-icon');
								// temp_update_status.addClass('checked-icon');
								create_pagination(1);
								refresh_page(1);
							}
							$("#div-loading").hide();
						}
					});
				}
				
      });
			
      $( "body" ).on( "click", ".update-error", function() {
				$("#button-yes").attr("data-action","update-error")
				$("#button-yes").attr("data-id",$(this).attr('data-id'))
        temp_update_error = $(this);
      });
      $( "body" ).on( "click", ".update-status", function() {
				$("#button-yes").attr("data-action","update-status")
				$("#button-yes").attr("data-id",$(this).attr('data-id'))
        temp_update_status = $(this);
      });
			
      $( "body" ).on( "click", ".update-status-admin", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-status-admin'); ?>/'+$(this).attr('data-id'),
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
							// create_pagination(1);
							// refresh_page(1);
							clearTimeout(timeoutId);
							temp.parent().html("Was taking");
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
			$( "body" ).on( "click", ".btn-send-email", function() {
				$("#sender").val($(this).attr("data-email"));
				$("#fullname").val($(this).attr("data-fullname"));
				$("#igaccount").val($(this).attr("data-igaccount"));
				$("#settingid").val($(this).attr("data-settingid"));
				$('#select-send-email').change();
      });
      $( "body" ).on( "click", "#button-send-email", function() {
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
							$(".row"+$("#settingid").val()).find(".update-error").removeClass('x-icon');
							$(".row"+$("#settingid").val()).find(".update-error").addClass('checked-icon');
            }
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
			
			
    });
  </script>		
  
@endsection
