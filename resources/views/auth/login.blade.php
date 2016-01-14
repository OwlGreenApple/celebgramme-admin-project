<html>
	<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
		<title>Celebgramme - Login</title>
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/sign-in.css') }}" rel="stylesheet">
	</head>
	<body style="  width: 100%;height: 100%;background-image: url('images/bg-login.jpg');background-size: cover;">
  <div class="container">  
		{!! Form::open(array('url'=>URL::ROUTE('auth.login'),'method'=>'post','class'=>"form-signin",)) !!}
			{!! csrf_field() !!}
      <h2>Please sign in</h2>
        <input type="text" class="form-control" id="username" name="username" placeholder="username" value="{{Input::old('username')}}">
        <input type="password" class="form-control" id="password" name="password" placeholder="password" value="{{Input::old('password')}}">
			
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember" id="remember"> <label for="remember">Remember me</label>
          </label>
        </div>      
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		{!! Form::close() !!}
  </div>
	</body>
</html>
