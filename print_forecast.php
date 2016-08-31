<?php
	session_start();
	include_once("backend/koneksi.php");
	include_once("backend/functions.php");
	
	$target = '';
	if(!isset($_GET['target'])){
		header("Location:err_404.php");
	}else{
		$target = input_filter($_GET['target']);
	}
	
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Print Out Forecasting Result</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-globe"></i> Forecasting Report
			  <?php
				 $dt = getdate();
				 $tgl = $dt['mday']."-".$dt['mon']."-".$dt['year'];
			  ?>
              <small class="pull-right">Date: <?=$tgl?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Forecasting Info
            <address>
              <strong>WeatherMP</strong><br>
              Komplek Setia Budi, Blok A-15<br>
              Medan Baru, Medan, Sumatera Utara<br>
              Phone: (061) 4530464 <br/>
              Email: info@cuacaku.com
            </address>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No.</th>
				  <th>Hari Ke-</th>
				  <th>ID Kota</th>
				  <th>Suhu Min</th>
				  <th>Suhu Max</th>
				  <th>Kelembapan Min</th>
				  <th>Kelembapan Max</th>
				  <th>Kecepatan Angin</th>
				  <th>Status Cuaca</th>
                </tr>
              </thead>
              <tbody>
              <?php
					// inisalisasi variabel array
								$datas = array();
								$suhuMin = array();
								$suhuMax = array();
								$kMin = array();
								$kMax = array();
								$kAngin = array();

								// get variabel POST 
								//$target = input_filter($_POST['target']);

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
								
								// print to table
								$r = 0;
								$no = 0;
								while($r < $target){
									foreach($datas as $key => $value){
										$no++;
										echo "<tr>";
										echo "<td>". ($no) ."</td>";
										echo "<td>". $predictions[$r][$key]["hari"] ."</td>";		
										echo "<td>". $predictions[$r][$key]["idKota"] ."</td>";	
										echo "<td>". $predictions[$r][$key]["suhuMin"] ."</td>";
										echo "<td>". $predictions[$r][$key]["suhuMax"] ."</td>";
										echo "<td>". $predictions[$r][$key]["kelembapanMin"] ."</td>";
										echo "<td>". $predictions[$r][$key]["kelembapanMax"] ."</td>";
										echo "<td>". $predictions[$r][$key]["kAngin"] ."</td>";	
										echo "<td>". $predictions[$r][$key]["cuaca"] ."</td>";	
										echo "</tr>";
									}
									$r++;	
								}
			  ?>
              </tbody>
            </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

      </section><!-- /.content -->
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>