<?php

	include_once("koneksi.php");
	include_once("functions.php");
	
	$nama = input_filter($_POST["name"]);
	$username = input_filter($_POST["username"]);
	$email = input_filter($_POST["email"]);
	$password = input_filter($_POST["password"]);
	$retype = input_filter($_POST["retype"]);
	$moto = input_filter($_POST["moto"]);
	$moto = empty($moto) ? "-" : $moto ;
	
	$status = 1;
	if(empty($username) || empty($password) || empty($email) || empty($password)){
		$message = base64_encode('Maaf, data tidak boleh kosong');
		echo "
			<script>
				document.location.href='../register.php?message={$message}&code=1'
			</script>
		";
		exit();
	}
	if($password != $retype){
		$message = base64_encode('Maaf, konfirmasi password anda salah');
		echo "
			<script>
				document.location.href='../register.php?message={$message}&code=1'
			</script>
		";
		exit();
	}
	
	// SQL String
	$sql = "INSERT INTO tbl_user(username, email, password, nama, moto, status) 
			VALUES('$username', '$email', '$password', '$nama', '$moto', '$status')";
	
	$query = $con->query($sql);
	
	if($query){
		$message = base64_encode('Akun anda berhasil dibuat..');
		echo "
			<script>
				document.location.href='../register.php?message={$message}&code=2'
			</script>
		";
	}else{
		$message = base64_encode('Maaf, proses registrasi gagal');
		
		echo "
			<script>
				document.location.href='../register.php?message={$message}&code=1'
			</script>
		";
	}	