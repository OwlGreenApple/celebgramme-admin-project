Hi , {{ucfirst(strtolower($user->fullname))}} <br>
<br>
<br>
<br>
<strong>Link to login Celebgramme</strong><a href="https://celebgramme.com/celebgramme">-----> Click Link Login Disini <----- </a><br>
<br>
<strong>Link to login Celebpost</strong><a href="https://celebpost.in/dashboard">-----> Click Link Login Disini <----- </a><br>

<?php 
	foreach ($arr_user as $data_user) {
?>
Berikut ini adalah user login celebgramme anda : <br>
<strong>Email :</strong> {{$data_user['user']->email}}<br>
	<?php 
		if ($data_user['password']<>"") { 
	?>
			<strong>Password :</strong> {{$data_user['password']}}<br>
			<br>
	<?php }
		else {
			echo "user dengan email ini sudah punya login celebgramme";
		}
	?>

<br>
<br>
Berikut ini adalah user login celebpost anda : <br>
<strong>Email :</strong> {{$data_user['user_celebpost']->email}}<br>
	<?php 
		if ($data_user['password_celebpost']<>"") { ?>
		<strong>Password :</strong> {{$data_user['password_celebpost']}}<br>
		<br>
<?php 
	}
	else {
		echo "user dengan email ini sudah punya login celebpost<br>";
	}
	echo "<br>";
}
?>

<br>
Salam hangat, <br>
<br>
Celebgramme.com
