<?php
	session_start();
	include_once("backend/koneksi.php");
	
	if(!isset($_SESSION['id_user']) || !isset($_SESSION['email'])){
		header('Location:login.php');
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
    <title>WeatherMP - Map Cuaca</title>
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBca7ZO0qRYSQvPRkfWYrygjvfk_6vo4HE" type="text/javascript"></script>
  
<script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      'Hujan Ringan': {
        icon: 'dist/stats/Hujan Ringan.png'
      },
	  'Hujan Sedang': {
		icon: 'dist/stats/Hujan Sedang.png'
	  },
	  'Hujan Lebat' : {
		icon: 'dist/stats/Hujan Lebat.png'
	  },
	  'Cerah Berawan' : {
		icon: 'dist/stats/Cerah Berawan.png'
	  },
	  'Berawan' : {
		icon: 'dist/stats/Berawan.png'
	  }
	  
    };

    function load() {
	 //alert('loading map..');
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(3.6335282, 98.6089159),
        zoom: 9,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("backend/map_marker_sumbagut.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("kota");
          var address = markers[i].getAttribute("address");
          var cuaca = markers[i].getAttribute("cuaca");
		  var tglMulai = markers[i].getAttribute("tanggalMulai");
		  var tglSampai = markers[i].getAttribute("tanggalSampai");
		  var waktuMulai = markers[i].getAttribute("waktuMulai");
		  var waktuSampai = markers[i].getAttribute("waktuSampai");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
		  var suhuMin = markers[i].getAttribute("suhuMin"); 
		  var suhuMax = markers[i].getAttribute("suhuMax"); 	
		  var kelembapanMin = markers[i].getAttribute("kelembapanMin");
		  var kelembapanMax = markers[i].getAttribute("kelembapanMax");
		  var arahAngin = markers[i].getAttribute("arahAngin"); 	
          var html = "<b>Nama Kota : " + name + "</b> <br/>" + 
					 "<b>Status Cuaca : </b> " + cuaca + "<br/>" +
					 "<b>Suhu Minimum : </b> " + suhuMin + "<br/>" +
					 "<b>Suhu Maksimum : </b> " + suhuMax + "<br/>" +
					 "<b>Kelembapan Minimum : </b> " + kelembapanMin + "<br/>" +
					 "<b>Kelembapan Maksimum : </b> " + kelembapanMax+ "<br/>" +
					 "<b>Arah Angin : </b> " + arahAngin + "<br/>" +
					 "<b>Tanggal : </b> " + tglMulai + " s.d " + tglSampai + "<br/>"
					 "<b>Pukul : </b> " + waktuMulai + "WIB s.d " + waktuSampai + "WIB <br/>" ;
          var icon = customIcons[cuaca] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
			animation: google.maps.Animation.DROP,
            icon: icon.icon
          });
		  //marker.addListener('click', toggleBounce);
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }
	
	function toggleBounce() {
	  if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	  } else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	  }
	}

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>

  </script>
 
  </head>
  
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

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
            Map Cuaca
            <small>Map Cuaca Se Sumatera Utara</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="starter.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li class="active">Map Cuaca</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header">
						  <h3 class="box-title">Map Cuaca</h3>
						</div><!-- /.box-header -->
						<div id="map" style="width:100%; height: 450px"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header">
						  <h3 class="box-title">Map Statistik Info</h3>
						</div><!-- /.box-header -->
						<div id="map" style="width:100%; height: 450px"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="map" style="width:100%; height: 500px"></div>
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
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
	
	<script>
		$(document).ready(function(){
			setInterval(function(){
				//alert('loading..');
				load();
			}, 60000);
		});
	</script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>