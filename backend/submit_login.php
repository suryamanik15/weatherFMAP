<?php

	include_once("koneksi.php");
	include_once("functions.php");
	
	$username = input_filter($_POST["username"]);
	$password = input_filter($_POST["password"]);
	
	if(empty($username) || empty($password)){
		$message = base64_encode('Maaf, username atau password kosong');
		echo "
			<script>
				document.location.href='../login.php?message={$message}&code=2'
			</script>
		";
	}
	
	// SQL String
	$sql = "SELECT * FROM tbl_user WHERE email='$username' AND password='$password' ";
	
	$rs = $con->query($sql);
	$num = $rs->num_rows;
	
	if($num == 1){
		// fetch the data
		$rs->data_seek(0);
		$user = $rs->fetch_assoc();
	
		// start session
		session_start();
		
		$_SESSION['id_user'] = $user['id_user'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['nama'] = $user['nama'];
		
		header('Location:../starter.php');
		
	}else{
		$message = base64_encode('Maaf, akun belum terdaftar');
		echo "
			<script>
				document.location.href='../login.php?message={$message}&code=1'
			</script>
		";
	}	