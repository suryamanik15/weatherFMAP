<?php
	session_start();
	include_once "backend/koneksi.php";
	include_once "backend/functions.php";
	
	if(!isset($_SESSION['id_user']) || !isset($_SESSION['email'])){
		header('Location:login.php');
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>WeatherMP - Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link href="plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<!-- DATA TABLES -->
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />

  </head>
  
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
	  <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
	  <img src='dist/img/loading.gif' width="64" height="64" /><br>Loading..</div>
      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Weather</b>MP</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
			<?php 
				include('pages/Widget/siteup.php');
			?>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/avatar2.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>Rozi Nasution</p>
              
			  <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
				<?php
					include('pages/Widget/sidemenu.php');
				?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Forecasting Cuaca
            <small>Data Forecasting</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Menu </a></li>
            <li class="active">Forecasting</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

			<div class="row">
				<div class="col-md-12">
					<!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header">
						  <h3 class="box-title">Parameter Forecasting</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" method="POST" action="data_forecasting.php" id="frmForecast">
						  <div class="box-body">
							<div class="form-group">
							  <label>Forecasting Target</label>
							  <select class="form-control" name="target" id="target">
								<option value='0'>=======  Pilih Target Forecasting  =====</option>
								<option value='3'>3 Hari Kedepan</option>
								<option value='4'>4 Hari Kedepan</option>
								<option value='5'>5 Hari Kedepan</option>
								<option value='6'>6 Hari Kedepan</option>
								<option value='7'>Seminggu Kedepan</option>
							  </select>
							</div>
						  </div><!-- /.box-body -->
						  <div class="box-footer">
							<button type="submit" class="btn btn-primary" id='btnAct'>Proses</button>&nbsp;
							<button type="reset" class="btn btn-info" id='btnClear'>Reset</button>
						  </div>
						</form>
					  </div><!-- /.box -->
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
						  <h3 class="box-title">Hasil Forecasting</h3>
						</div><!-- /.box-header -->
					</div>
					<div class="box-body">
						<table id="dataTable" class="table table-bordered table-hover">
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
							 				
							if(isset($_POST['target'])){
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
							}
					?>
							 
							</tbody>
						</table>
					</div>
				</div>
				<?php
				 if(isset($_POST['target'])){
					$tgr = input_filter($_POST['target']);
				?>
					  <!-- this row will not appear when printing -->
					  <div class="row no-print">
						<div class="col-xs-12">
						  <a href="print_forecast.php?target=<?=$tgr?>" target="_blank" class="btn btn-default" style="margin-left:2%;">
						  <i class="fa fa-print"></i> Print</a>
						</div>
					  </div>
				<?php
					}
				?>	
			</div>
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          CuacaKu - Portal Aplikasi Forecasting dan Peramalan Cuaca
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?=date('Y');?> <a href="#">Company</a>.</strong> All rights reserved.
      </footer>
      
      <!-- Control Sidebar -->      
      <aside class="control-sidebar control-sidebar-dark">                
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>              
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3> 
            <ul class='control-sidebar-menu'>
              <li>
                <a href='javascript::;'>               
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>                                    
                </a>
              </li>                         
            </ul><!-- /.control-sidebar-menu -->         

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">            
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
	
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
	<!-- page script -->
    <script type="text/javascript">
	   $(document).ready(function(){
			$(document).ajaxStart(function(){
				$("#wait").css("display", "block");
			});
			$(document).ajaxComplete(function(){
				$("#wait").css("display", "none");
			});
			$("#btnAct").click(function(){
				var target = $("#target").val();
				if(target == 0){
					alert("Maaf, pilih dahulu target forecasting anda !!");
				}else{
					$("#frmForecast").submit();
				}
				return false;
			});
			
			$("#btnClear").click(function(){
				var c = confirm("Clear Data Forecast ?");
				if(c){
					document.location.href='data_forecasting.php';
				}else{
					// do nothing
				}
				
				return false;
			});
			
		});
		
      $(function () {
        $("#example1").dataTable();
        $('#dataTable').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
<?php
	$con->close();
?>