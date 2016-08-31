<?php
	
	include_once("koneksi.php");
	include_once("functions.php");
	
	$xmlUrl = "http://data.bmkg.go.id/propinsi_00_2.xml";
	$url = "http://data.bmkg.go.id/";
	
	$xmlStr = file_get_contents($xmlUrl);
	$xmlObj = simplexml_load_string($xmlStr);
	$arrXml = objectsIntoArray($xmlObj);
	
	$sql = "";
	
	for($i=23; $i <= 48; $i++){
		  // ADD TO SQL String
		  $sql .= "INSERT INTO tbl_infocuaca(id_lokasi, nama, cuaca, suhuMin, suhuMax, 
					kelembapanMin, kelembapanMax, kecepatanAngin, arahAngin, tglMulai, tglSampai, waktuMulai, waktuSelesai) VALUES('". $arrXml['Isi']['Row'][$i]['idKota'] ."', '". $arrXml['Isi']['Row'][$i]['Kota'] ."' , '". $arrXml['Isi']['Row'][$i]['Cuaca'] ."', '". $arrXml['Isi']['Row'][$i]['SuhuMin'] ."', '". $arrXml['Isi']['Row'][$i]['SuhuMax'] ."', '". $arrXml['Isi']['Row'][$i]['KelembapanMin'] ."', '". $arrXml['Isi']['Row'][$i]['KelembapanMax'] ."', '". $arrXml['Isi']['Row'][$i]['KecepatanAngin'] ."', '". $arrXml['Isi']['Row'][$i]['ArahAngin'] ."', '". $arrXml['Tanggal']['Mulai'] ."', '". $arrXml['Tanggal']['Sampai'] ."', '". $arrXml['Tanggal']['MulaiPukul'] ."', '". $arrXml['Tanggal']['SampaiPukul'] ."');";
	
	}
	
	$query = $con->multi_query($sql);
	if($query){
		echo "
			Fetching Data Ke dalam Database Selesai..
		";
	}else{
		echo "
			Fetching gagal, ada query yang salah..
		";
	}
	
	
	