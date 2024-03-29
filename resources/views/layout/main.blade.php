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
  <link href="{{ asset('DataTables/DataTables/css/jquery.dataTables.min.css') }}" rel="stylesheet"></link>
	
	<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/script.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/canvasjs/canvasjs.min.js') }}"></script>
  <script src="{{ asset('DataTables/DataTables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/datetime-moment.js') }}"></script>
	<script>
		$(document).ready(function(){
			$("#div-loading").hide();
      $( "body" ).on( "click", "#button-edit-config", function() {
        $.ajax({
          url: '<?php echo url('update-config'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-config").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
						if (result=="success"){
							alert("Config changed");
						} else {
							alert("Error");
						}
            $("#div-loading").hide();
          }
        });
      });
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


	@include('modals.change-password')
	@include('modals.change-config')

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
		<p>Copyright © <a href="#" class="terms">activfans.com</a>. All rights reserved.</p>	
	</div>
    <div id="div-loading">
      <div class="loadmain"></div>
      <div class="background-load"></div>
    </div>
	
</body>
</html>
