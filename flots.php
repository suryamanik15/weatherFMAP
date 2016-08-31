<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>WeatherMP | Charts</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Weather</b>MP</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
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
		<?php
			$dt = getdate();
			$tgl = $dt['mday'];
			$tahun = $dt['year'];
			$bulan = '';
			switch($dt['mon']){
				case '01' : $bulan = "Januari";
							break;
				case '02' : $bulan = "Februari";
							break;		
				case '03' : $bulan = "Maret";
							break;	
				case '04' : $bulan = "April";
							break;			
				case '05' : $bulan = "Mei";
							break;		
				case '06' : $bulan = "Juni";
							break;
				case '07' : $bulan = "Juli";
							break;			
				case '08' : $bulan = "Agustus";
							break;			
				case '09' : $bulan = "September";
							break;				
				case '10' : $bulan = "Oktober";
							break;			
				case '01' : $bulan = "Januari";
							break;			
			}
			$tanggal_hari_ini = $tgl ." ". $bulan ." ". $tahun;
		?>
        <section class="content-header">
          <h1>
            View Chart
            <small>Grafik Cuaca Hari ini (<?=$tanggal_hari_ini?>)</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forecast Chart</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- interactive chart -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Forecasting Graph Result</h3>
                  <div class="box-tools pull-right">
                    Real time
                    <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                      <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
                      <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                  <div id="interactive" style="height: 350px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
		  <div class="row no-print">
			<div class="col-xs-12">
			   <a href="backend/map_marker_sumbagut.php" target="_blank" class="btn btn-default" style="margin-left:2%;">
			   <i class="glyphicon glyphicon-copy"></i> Show Data In XML Format</a>
			</div>
		</div>

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
       
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>

    <!-- Page script -->
    <script type="text/javascript">

      $(function () {

        /*
         * Flot Interactive Chart
         * -----------------------
         */
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = getDataFromServer(); 
		var totalPoints = 50;
		
        function getRandomData() {

          if (data.length > 0)
            data = data.slice(1);

          // Do a random walk
		  
          while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 25,
            y = prev + Math.random() * 10 - 5;

           if (y < 0) {
              y = 0;
            } else if (y > 100) {
              y = 100;
            }

            data.push(y);
          }

          // Zip the generated y values with the x values
          var res = [];
          for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]]);
          }

          return res;
        }
		
		/* function to get data from XML file */
		function getDataFromServer(){
			var values = [];
			// Change this depending on the name of your PHP file
			downloadUrl("backend/map_marker_sumbagut.php", function(data) {
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var suhuMin = markers[i].getAttribute("suhuMin"); 
					values.push(suhuMin);
				}
			});
			return values;
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

        var interactive_plot = $.plot("#interactive", [getRandomData()], {
          grid: {
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: "#3c8dbc"
          },
          lines: {
            fill: true, //Converts the line chart to area chart
            color: "#3c8dbc"
          },
          yaxis: {
            min: 0,
            max: 100,
            show: true
          },
          xaxis: {
            show: true
          }
        });

        var updateInterval = 500; //Fetch data ever x milliseconds
        var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
        function update() {

          interactive_plot.setData([getRandomData()]);

          // Since the axes don't change, we don't need to call plot.setupGrid()
          interactive_plot.draw();
          if (realtime === "on")
            setTimeout(update, updateInterval);
        }

        //INITIALIZE REALTIME DATA FETCHING
        if (realtime === "on") {
          update();
        }
        //REALTIME TOGGLE
        $("#realtime .btn").click(function () {
          if ($(this).data("toggle") === "on") {
            realtime = "on";
          }
          else {
            realtime = "off";
          }
          update();
        });
        /*
         * END INTERACTIVE CHART
         */

		 

      });

      /*
       * Custom Label formatter
       * ----------------------
       */
      function labelFormatter(label, series) {
        return "<div style='font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;'>"
                + label
                + "<br/>"
                + Math.round(series.percent) + "%</div>";
      }
    </script>
  </body>
</html>
