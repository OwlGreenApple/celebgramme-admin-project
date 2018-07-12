Hi , {{ucfirst(strtolower($user->fullname))}} <br>
<br>
<br>
<?php if ($password<>"") { ?>
Berikut ini adalah user login celebgramme anda : <br>
<strong>Email :</strong> {{$user->email}}<br>
<strong>Password :</strong> {{$password}}<br>
<br>
<?php } ?>
<br>
<strong>Link to login </strong><a href="http://celebgramme.com/celebgramme">-----> Click Link Login Disini <----- </a><br>

<br>
<br>
<?php if ($password_celebpost<>"") { ?>
Berikut ini adalah user login celebpost anda : <br>
<strong>Email :</strong> {{$user_celebpost->email}}<br>
<strong>Password :</strong> {{$password_celebpost}}<br>
<br>
<?php } ?>
<br>
<strong>Link to login </strong><a href="http://celebpost.in/dashboard">-----> Click Link Login Disini <----- </a><br>

<br>
Salam hangat, <br>
<br>
Celebgramme.com
