<?php
	
	// Start XML file, create parent node
	function parseToXML($htmlStr){
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
	}
	
	$xmlUrl = "http://data.bmkg.go.id/propinsi_00_2.xml";
	$url = "http://data.bmkg.go.id/";

	require_once "functions.php";
	
	$xmlStr = file_get_contents($xmlUrl);
	$xmlObj = simplexml_load_string($xmlStr);
	$arrXml = objectsIntoArray($xmlObj);
	
	header("Content-type: text/xml");

	// Start XML file, echo parent node
	echo '<markers>';
		
	//print_r($arrXml); //print array untuk melihat datanya
	//echo $arrXml['Tanggal']['Mulai']; // tampilkan tanggal data perkiraan cuacanya
	//echo print_r($arrXml['Isi']['Row']['42']); // id Medan = 42
	
	for($i=23; $i <= 48; $i++){
		  // ADD TO XML DOCUMENT NODE
		  echo '<marker ';
		  echo 'kota="' . $arrXml['Isi']['Row'][$i]['Kota'] . '" ';
		  echo 'lat="' . $arrXml['Isi']['Row'][$i]['Lintang'] . '" ';
		  echo 'lng="' . $arrXml['Isi']['Row'][$i]['Bujur'] . '" ';
		  echo 'cuaca="' . $arrXml['Isi']['Row'][$i]['Cuaca'] . '" ';
		  echo 'suhuMin="' . $arrXml['Isi']['Row'][$i]['SuhuMin'] . '" ';
		  echo 'suhuMax="' . $arrXml['Isi']['Row'][$i]['SuhuMax'] . '" ';
		  echo 'kelembapanMin="' . $arrXml['Isi']['Row'][$i]['KelembapanMin'] . '" ';
		  echo 'kelembapanMax="' . $arrXml['Isi']['Row'][$i]['KelembapanMax'] . '" ';
		  echo 'arahAngin="' . $arrXml['Isi']['Row'][$i]['ArahAngin'] . '" ';
		  echo 'kecepatanAngin="' . $arrXml['Isi']['Row'][$i]['KecepatanAngin'] . '" ';
		  echo 'tanggalMulai="' . $arrXml['Tanggal']['Mulai'] . '" ';
		  echo 'tanggalSampai="' . $arrXml['Tanggal']['Sampai'] . '" ';
		  echo 'waktuMulai="' . $arrXml['Tanggal']['MulaiPukul'] . '" ';
		  echo 'waktuSampai="' . $arrXml['Tanggal']['SampaiPukul'] . '" ';
		  echo 'idKota="' . $arrXml['Isi']['Row'][$i]['idKota'] . '" ';
		  echo '/>';
	}
	
	// End XML file
	echo '</markers>';
