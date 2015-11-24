<html>
	<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>Axiasmart - 404</title>
    
	</head>
	<body>
	<i class="logo-error"></i>
		<div class="center">
			<i class="logo"></i>
			<p class="main-message">Sorry, the page you were looking for doesn&rsquo;t exist.</p>
			<p class="direction">Go back to <a href="{{ url('/') }}">axiasmart.com</a></p>
			<a href="{{ URL::previous() }}" class="button-back">Back</a>
		</div>
		<div class="footer">
		</div>
	</body>
</html>
