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
    <title>WeatherMP - Data Lokasi</title>
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
          <span class="logo-lg"><b>Cuaca</b>KU</span>
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
            Lokasi Terdata
            <small>Daftar</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Menu </a></li>
            <li class="active">Lokasi Terdaftar</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

			<div class="row">
				<div class="col-md-12">
					<!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header">
						  <h3 class="box-title">Tambah Data Lokasi</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" method="POST" action="backend/add_lokasi.php" id="frmAddPosting">
						  <div class="box-body">
							<div id="grTempat">
								<div class="form-group">
								  <label for="lblTempat">Nama Tempat / Lokasi</label>
								  <input type="text" class="form-control" id="txtLokasi" name="lokasi" placeholder="Nama Tempat / Lokasi">
								</div>
							</div>
							<div id="grID">	
								<div class="form-group">
								  <label for="">ID Kota (*<i>Berdasarkan Data BMKG</i>)</label>
								  <input type="text" class="form-control" id="txtID" name="idkota" placeholder="ID Kota">
								</div>
							</div>	
							<div id="grLat">
								<div class="form-group">
								  <label for="">Latitude (Lintang)</label>
								  <input type="text" class="form-control" id="txtLat" name="lat" placeholder="Latitude (Lintang) ">
								</div>
							</div>
							<div id="grLong">		
								<div class="form-group">
								  <label for="">Longitude (Bujur)</label>
								  <input type="text" class="form-control" id="txtLong" name="long" placeholder="Longitude (Bujur) ">
								</div>
							</div>	
						  </div><!-- /.box-body -->
						  <div class="box-footer">
							<button type="submit" class="btn btn-primary" id='btnTambah'>Tambah</button>&nbsp;
							<button type="reset" class="btn btn-info" >Reset</button>
						  </div>
						</form>
					  </div><!-- /.box -->
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
						  <h3 class="box-title">Daftar Lokasi Terdata</h3>
						</div><!-- /.box-header -->
					</div>
					<div class="box-body">
						<table id="dataTable" class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>No.</th>
								<th>ID Kota</th>
								<th>Nama Lokasi</th>
								<th>Lintang</th>
								<th>Bujur</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							  </tr>
							</thead>
							<tbody>
							<?php
								
								$str = "SELECT id, idKota, nama, lintang, bujur FROM tbl_lokasi 
										ORDER BY nama ASC ";
								$res = $con->query($str);
								$no = 0;
								while($dt = $res->fetch_assoc()){
									$idKota = $dt['idKota'];
									$lokasi = input_filter($dt['nama']);
									$no++;
									echo "
										<tr>
											<td>{$no}</td>
											<td>{$dt['idKota']}</td>
											<td>{$dt['nama']}</td>
											<td>{$dt['lintang']}</td>
											<td>{$dt['bujur']}</td>
											<td><a href='view_maps.php?idKota={$idKota}&lokasi={$lokasi}' 
											title='View Maps'><span class='glyphicon glyphicon-map-marker'></a></span></td>
											<td><a href='' 
											title='Edit Data'><span class='glyphicon glyphicon-pencil'></a></span></td>
											<td><a href='' title='Delete Data'><span class='glyphicon glyphicon-trash'></a></span></td>
										</tr>
									";
								}								
							?>
							 
							</tbody>
						</table>
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
			$("#btnTambah").click(function(){
				//$("#txt").load("demo_ajax_load.asp");
				var lokasi = $("#txtLokasi").val();
				var idKota = $("#txtID").val();
				var lat = $("#txtLat").val();
				var longtude = $("#txtLong").val();
				
				if(lokasi == "" || idKota == "" || lat == "" || longtude == ""){
					loadError();		
				}else{
					$('#frmAddPosting').submit();
				}
				//alert('Submit !!');
				return false;
			});
			
		});
		
		// for form validate
		function loadError(){
			$("#grTempat").html(" <div class='form-group has-error'><label class='control-label' for='inputError'>" +
						" <i>* field tidak boleh kosong</i></label>" +
                      "<input type='text' class='form-control' id='txtLokasi' name='lokasi' placeholder='Nama Tempat / Lokasi'/></div>");
			$("#grID").html(" <div class='form-group has-error'><label class='control-label' for='inputError'>" +
						"<i>*field tidak boleh kosong</i></label>" +
                      "<input type='text' class='form-control' id='txtID' name='idkota' placeholder='ID Kota'/></div>");	
			$("#grLat").html(" <div class='form-group has-error'><label class='control-label' for='inputError'>" +
						"<i>*field tidak boleh kosong</i></label>" +
                      "<input type='text' class='form-control' id='txtLat' name='lat' placeholder='Latitude (Lintang)'/></div>");	
			$("#grLong").html(" <div class='form-group has-error'><label class='control-label' for='inputError'>" +
						"<i>*field tidak boleh kosong</i></label>" +
                      "<input type='text' class='form-control' id='txtLong' name='long' placeholder='Longitude (Bujur)'/></div>");		  
		}
		
	
 
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