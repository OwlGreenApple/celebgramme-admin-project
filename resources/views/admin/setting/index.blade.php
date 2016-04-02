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
</style>

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
      <tr>
        <th>No. </th>
        <th>Password Error</th>
        <th>Insta username</th>
        <th>Insta password</th>
        <th>Fullname (email)</th>
        <th>Filename (Spiderman)</th>
        <th>Updates</th>
				
        <th>Download Hashtags</th>
        <th>Download Usernames</th>
        <th>Download Comments</th>
				
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
        url: '<?php echo url('pagination-setting'); ?>',
        type: 'get',
        data: {
          page : page,
					keyword: $("#keyword-search").val(),
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
    $(document).ready(function(){
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);
			
			$( "body" ).on( "click", ".download-hashtags", function() {
				window.location="<?php echo url('download-hashtags'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find("select option:selected").attr("data-val");
      });
			$( "body" ).on( "click", ".download-usernames", function() {
				window.location="<?php echo url('download-usernames'); ?>/"+$(this).attr("data-id")+"/"+$(this).parent().find("select option:selected").html();
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
        create_pagination(1);
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
