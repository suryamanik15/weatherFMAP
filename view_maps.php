<?php
	session_start();
	include_once("backend/koneksi.php");
	include_once("backend/functions.php");
	
	if(!isset($_SESSION['id_user']) || !isset($_SESSION['email'])){
		header('Loacation:login.php');
	}
	
	/* fetch information via GET Method  */
	$idKota = $_GET['idKota'];
	$lokasi = input_filter($_GET['lokasi']);
	
	$str = "SELECT nama, lintang, bujur FROM tbl_lokasi WHERE idKota = ?";
	
	
	$rs = $con->prepare($str);
	$rs->bind_param('i', $idKota);
	$rs->execute();
	/* Get the result */
	$result = $rs->get_result();
	
	$nama = '';
	$lintang = '';
	$bujur = '';
	
	while ($row = $result->fetch_assoc()) {
       $nama = $row['nama'];
	   $lintang = $row['lintang'];
	   $bujur = $row['bujur'];
	}
	
	
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>WeatherMP - View Maps </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
	<style>
		#map-canvas {
		  width: 100%;
		  height: 100%;
		}
		.gm-style-iw {
		  text-align: center;
		}
  </style>
  
  </head>
  
  <body class="skin-blue sidebar-mini" onload="loadMaps()">
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
            View Maps
            <small>Nama Lokasi : <?=$nama?> (<?=$lintang?> , <?=$bujur?>)</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Menu </a></li>
            <li class="active">Map Lokasi</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header">
						  <h3 class="box-title">Lokasi</h3>
						</div><!-- /.box-header -->
						<div id="map" style="width:100%; height: 500px"></div>
					</div>
				</div>
			</div>
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          WeatherMP - Portal Aplikasi Forecasting dan Peramalan Cuaca
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?=date('Y');?> <a href="#">Company</a>.</strong> All rights reserved.
      </footer>
   
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBca7ZO0qRYSQvPRkfWYrygjvfk_6vo4HE" type="text/javascript"></script>
  
<script type="text/javascript">
	
    var customIcons = {
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function loadMaps() {
      var map = new google.maps.Map(document.getElementById("map"), {
		
        center: new google.maps.LatLng('<?=$lintang?>', '<?=$bujur?>'),
        zoom: 11,
        //mapTypeId: 'roadmap'
		mapTypeId : 'terrain'
      });
      var infoWindow = new google.maps.InfoWindow;

		var name = '<?=$nama?>';
        var point = new google.maps.LatLng(
              parseFloat(<?=$lintang?>),
              parseFloat(<?=$bujur?>));
          
          var html = "<b>Nama Kota : " + name + "</b> <br/>";
          var icon = customIcons['bar'] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
		  
       bindInfoWindow(marker, map, infoWindow, html);	
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

  </script>
  </body>
</html>
<?php
	/* free results */
   $rs->free_result();
   
   $rs->close();
	
	$con->close();
?>