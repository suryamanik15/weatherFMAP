<?php

include_once("koneksi.php");
include_once("functions.php");

// inisalisasi variabel array
$datas = array();
$suhuMin = array();
$suhuMax = array();
$kMin = array();
$kMax = array();
$kAngin = array();

// get variabel POST 
$target = input_filter($_POST['target']);

$sql = "SELECT * FROM tbl_infocuaca GROUP BY id_lokasi";
$rs = $con->query($sql);
$i = 0;
while($dt = $rs->fetch_assoc()){
	$datas[$i][0] = $dt['id_lokasi'];
	$datas[$i][1] = $dt['nama'];
	$datas[$i][2] = $dt['arahAngin'];
	$datas[$i][3] = $dt['cuaca'];
	
	// insert to another paramaeters
	$suhuMin[$i] = $dt['suhuMin'];
	$suhuMax[$i] = $dt['suhuMax'];
	$kMin[$i] = $dt['kelembapanMin'];
	$kMax[$i] = $dt['kelembapanMax'];
	$kAngin[$i]= $dt['kecepatanAngin'];
	$i++;
}

$differences = array();
$lastitem = array();
$lastday = null;
$lastday2 = null;
$lastday3 = null;
$lastday4 = null;
$lastday5 = null;

$i = 0;
while( $i < count($datas)){
	if(empty($lastday) && empty($lastday2) && empty($lastday3) && empty($lastday4) 
			&& empty($lastday5)){
		$lastday = $suhuMin[$i];
		$lastday2 = $suhuMax[$i];
		$lastday3 = $kMin[$i];
		$lastday4 = $kMax[$i];
		$lastday5 = $kAngin[$i];	
		continue;
	}
    $differences[$i]['suhuMin'] = $suhuMin[$i] - $lastday;
	$differences[$i]['suhuMax'] = $suhuMax[$i] - $lastday2;
	$differences[$i]['kMin'] = $kMin[$i] - $lastday3;
	$differences[$i]['kMax'] = $kMax[$i] - $lastday4;
	$differences[$i]['kAngin'] = $kAngin[$i] - $lastday5;
	
    $lastday  = $suhuMin[$i];
	$lastday2 = $suhuMax[$i];
	$lastday3 = $kMin[$i];
	$lastday4 = $kMax[$i];
	$lastday5 = $kAngin[$i];

    //use this later
    $lastitem[$i] = array("hari"=>$i, "suhuMin"=>$suhuMin[$i], "suhuMax"=>$suhuMax[$i], 
				"kelembapanMin"=>$kMin[$i],"kelembapanMax"=>$kMax[$i], "kAngin"=>$kAngin[$i], 
				"id_lokasi"=>$datas[$i][0], "nama" => $datas[$i][1], "arahAngin"=>$datas[$i][2], 
				"cuaca" =>$datas[$i][3]);
	$i++;			
}
	
//get the average difference per year
$count = 0;
$total = 0;
$total2 = 0; 
$total3 = 0;
$total4 = 0; 
$total5 = 0;
$j = 0;
while($j < count($differences)){
	$count++;
	$total += $differences[$j]['suhuMin']; // suhu Min
	$total2 += $differences[$j]['suhuMax']; // suhu Max
	$total3 += $differences[$j]['kMin']; // Kelembapan Min
	$total4 += $differences[$j]['kMax']; // Kelembapan Max
	$total5 += $differences[$j]['kAngin']; // Kecepatan Angin

	//echo $differences[$j]['suhuMin'] . "<br/>";
	$j++;
}


$average1 = number_format(($total/$count), 2);
$average2 = number_format(($total2/$count), 2);
$average3 = number_format(($total3/$count), 2);
$average4 = number_format(($total4/$count), 2);
$average5 = number_format(($total5/$count), 2);

//make a prediction
$predictions = array();
$prediction = array();
$t = 0;
while($t < $target){
	foreach($datas as $key => $value){
		$day = isset($day) ? $day+1 : $lastitem[$t]["hari"]+1;
		$psuhuMin = isset($psuhuMin) ? $psuhuMin + floatval($average1) : $lastitem[$key]["suhuMin"] + floatval($average1);
		$psuhuMax = isset($psuhuMax) ? $psuhuMax + floatval($average2) : $lastitem[$key]["suhuMax"]+floatval($average2);
		$pkelembapanMin = isset($pkelembapanMin) ? $pkelembapanMin + floatval($average3) : $lastitem[$key]["kelembapanMin"]+floatval($average3);
		$pkelembapanMax = isset($pkelembapanMax) ? $pkelembapanMax + floatval($average4) : $lastitem[$key]["kelembapanMax"]+floatval($average4);
		$pkAngin = isset($pkAngin) ? $pkAngin + floatval($average5) : $lastitem[$key]["kAngin"] + floatval($average5);
		
		$predictions[$t][$key]["hari"] = "hari ke-".($t + 1);
		$predictions[$t][$key]["suhuMin"] = $psuhuMin;
		$predictions[$t][$key]["suhuMax"] = $psuhuMax;	
		$predictions[$t][$key]["kelembapanMin"] = $pkelembapanMin;
		$predictions[$t][$key]["kelembapanMax"] = $pkelembapanMax;
		$predictions[$t][$key]["kAngin"] = $pkAngin;
		$predictions[$t][$key]["idKota"] = $lastitem[$key]['id_lokasi'];
		$predictions[$t][$key]["nama"] = $lastitem[$key]['nama'];
		$predictions[$t][$key]["arahAngin"] = $lastitem[$key]['arahAngin'];
		$predictions[$t][$key]["cuaca"] = $lastitem[$key]['cuaca'];
	}	
	$t++;
}

echo $target ." hari ke depan <br/>";
print_r($predictions);
/*foreach($differences as $item =>$val){
	echo $val . "<br/>";
}*/	
//echo "Suhu Min Hari pertama " . $predictions[0][0]["suhuMin"] . "<br/>";
//echo "Suhu Min Hari kedua " . $predictions[0][1]["suhuMin"] . "<br/>";