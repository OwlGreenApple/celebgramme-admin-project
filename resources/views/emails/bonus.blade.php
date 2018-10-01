Hi , {{ucfirst(strtolower($user->fullname))}} <br>
<br>
Selamat,<br>Bonus anda sudah datang. <br>
Anda mendapatkan bonus activfans selama {{$jumlah_hari}} hari
<br>
<br>
<?php if ($password<>"") { ?>
Berikut ini adalah user login anda : <br>
<strong>Email :</strong> {{$user->email}}<br>
<strong>Password :</strong> {{$password}}<br>
<br>
<?php } ?>
<br>
<strong>Link to login </strong><a href="http://activfans.com/dashboard">-----> Click Link Login Disini <----- </a><br>

<br>
Salam hangat, <br>
<br>
activfans.com
