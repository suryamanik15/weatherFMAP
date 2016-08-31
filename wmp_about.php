<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>WeatherMP | About</title>
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
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="public.php" class="navbar-brand"><b>Weather</b>MP</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              WeatherMP
              <small>Version 1.0</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i>Menu</a></li>
              <li class="active">Tentang WeatherMP</li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="callout callout-info">
              <h4>WeatherMP System Information</h4>
              <p>
					<table border='0'>
						<tr>
							<td>Name</td>
							<td> : </td>
							<td>Weather Mapping (MP)</td>
						</tr>
						<tr>
							<td>Version</td>
							<td> : </td>
							<td>1.0</td>
						</tr>
						<tr>
							<td>Author</td>
							<td> : </td>
							<td>Rozi Nasution</td>
						</tr>
					</table>
			  </p>
            </div>
        
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Tentang Weather Mapping / WeatherMP</h3>
              </div>
              <div class="box-body">
                Weather Mapping atau WeatherMP adalah sebuah layanan forecasting cuaca <i>Online</i> yang memanfaatkan data melalui 
				API yang disediakan oleh Server BMKG dan OpenweatherMap. <br/>
				Operator maupun <i>public user</i> dapat melihat informasi data cuaca secara <i>Real-Time</i> terkini. Khusus untuk Operator
				dapat melakukan proses forecasting data cuaca, sedangkan public user dapat melihat informasi cuaca aktual dan informasi hasil
				forecasting beberapa hari kedepan.
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        </div><!-- /.container -->
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
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>
