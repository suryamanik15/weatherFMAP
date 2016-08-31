<?php

function objectsIntoArray($arrObjData, $arrSkipIndices = array()){
	$arrData = array();
	// if input is object, convert into array
	if (is_object($arrObjData)) {
		$arrObjData = get_object_vars($arrObjData);
	}

	if (is_array($arrObjData)) {
		foreach ($arrObjData as $index => $value) {
			if (is_object($value) || is_array($value)) {
				$value = objectsIntoArray($value, $arrSkipIndices); // recursive call
			}
			if (in_array($index, $arrSkipIndices)) {
				continue;
			}
			$arrData[$index] = $value;
		}
	}
	return $arrData;
}

	$xmlUrl = "http://data.bmkg.go.id/propinsi_00_2.xml";
	$url = "http://data.bmkg.go.id/";

	$xmlStr = file_get_contents($xmlUrl);
	$xmlObj = simplexml_load_string($xmlStr);
	$arrXml = objectsIntoArray($xmlObj);

	//print_r($arrXml); //print array untuk melihat datanya
	//echo $arrXml['Tanggal']['Mulai']; // tampilkan tanggal data perkiraan cuacanya
	//echo print_r($arrXml['Isi']['Row']['23']); // id Medan = 42
	// ID Kota Sumut Id = 23 s.d 48
	for($i=23; $i <= 48; $i++){
			echo "Nama Kota : " . $arrXml['Isi']['Row'][$i]['Kota'];
			echo "<br/>Lintang : " . $arrXml['Isi']['Row'][$i]['Lintang'];
			echo "<br/>Bujur : " . $arrXml['Isi']['Row'][$i]['Bujur'];
			echo "<br/><br/>";
	}
	//echo "<br/>Status Cuaca : " . $arrXml['Isi']['Row']['42']['Cuaca'];
	
	
	//$gambar_icon = $url . $arrXml['Isi']['Row']['42']['_symbol'];
	//echo "<br/><img src='$gambar_icon' />";
	
	
	