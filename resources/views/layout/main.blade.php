<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Celebgramme Administrator Area</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/admin_favicon.ico') }}">

	<link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet">
	
	<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/script.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
	<script>
		$(document).ready(function(){
			$("#div-loading").hide();
      $( "body" ).on( "click", "#button-edit-password", function() {
        $.ajax({
          url: '<?php echo url('update-password'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-password").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
						if (result=="success"){
							alert("Password changed");
						} else {
							alert("Error");
						}
            $("#div-loading").hide();
          }
        });
      });
		});
	</script>
</head>
<body class="body_admin">

  <!-- Modal -->
  <div class="modal fade" id="modalChangePassword" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="form-edit-password">
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Old Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input Old Password" name="old_password" id="old-password">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">New Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input New Password" name="new_password" id="new-password">
              </div>
            </div>  
            <div class="form-group form-group-sm row">
              <label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Confirm Password</label>
              <div class="col-sm-8 col-md-6">
                <input type="password" class="form-control" placeholder="Input Confirm Password" name="new_password_confirmation" id="confirm-password">
              </div>
            </div>  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="button-edit-password">Submit</button>
        </div>
      </div>
      
    </div>
  </div>


  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
			<a class="navbar-brand" href="home"><div class="logo fl"> </div></a>
      </div>
	  @include('layout.axs-menu')
    </div>
  </nav>
  <div class="container theme-showcase" role="main">
    @yield('content')
  </div>
	<div class="footer_container">
		<p>Copyright © <a href="#" class="terms">celebgramme.com</a>. All rights reserved.</p>	
	</div>
    <div id="div-loading">
      <div class="loadmain"></div>
      <div class="background-load"></div>
    </div>
	
</body>
</html>
