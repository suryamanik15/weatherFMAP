<?php
    include_once("koneksi.php");
	include_once("functions.php");
	
	$lokasi = input_filter($_POST['lokasi']);
	$idkota = input_filter($_POST['idkota']);
	$lat = input_filter($_POST['lat']);
	$long = input_filter($_POST['long']);
	
	$str = "INSERT INTO tbl_lokasi(idKota, nama,lintang,bujur) 
			VALUES(?,?,?,?)";
	
	$stm = $con->prepare($str);

	$stm->bind_param('isss', $idkota, $lokasi, $lat, $long);
	$query = $stm->execute();
	if($query){
		echo "
			<script>
				document.location.href='../data_lokasi.php';
			</script>
		";
	}else{
		echo "
			<script>
				alert('Oppss, ada problem , data gagal ditambah !!');
				document.location.href='../data_lokasi.php';
			</script>
		";	
	}

	$stm->close();
	$con->close();
?>