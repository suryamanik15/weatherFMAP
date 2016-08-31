<?php
	
	include_once("backend/functions.php");
	
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href=""><b>Weather</b>MP</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Registrasi Akun Baru</p>
		<?php
			if(isset($_GET['message']) && isset($_GET['code'])){
				$code = input_filter($_GET['code']);
				$message = base64_decode($_GET['message']);
				if($code == 1){
					echo "<div class='alert alert-danger alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<h4><i class='icon fa fa-ban'></i> Registrasi gagal..</h4>
							{$message}
					</div>";
				}
				if($code == 2){
					
					echo "<div class='alert alert-success alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<h4>	<i class='icon fa fa-check'></i> Registrasi Sukses !!</h4>
								{$message}
						</div>";
				}
			}
		?>
        <form action="backend/submit_register.php" method="post" id="frmRegister">
          <div class="form-group has-feedback">
            <input type="text"  name="name" id="name" class="form-control" placeholder="Nama Lengkap"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
		  <div class="form-group has-feedback">
            <input type="text"  name="username" id="username" class="form-control" placeholder="Username"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="retype" id="retype" class="form-control" placeholder="Retype password"/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
		   <div class="form-group has-feedback">
            <input type="text" name="moto" id="moto" class="form-control" placeholder="Moto Singkat Anda (*opsional)"/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="check" id="check"> I agree to the <a href="#">terms</a>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" id="btnRegister">Registrasi</button>
            </div><!-- /.col -->
          </div>
        </form>        
        <a href="login.php" class="text-center">Saya Sudah Punya Akun</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
			$("#btnRegister").click(function(){
				var name = $("#name").val();
				var username = $("#username").val();
				var email = $("#eamil").val();
				var password = $("#password").val();
				var retype = $("#retype").val();
				var cek = $("#check").val();
				
				if(cek == ''){
					alert('Maaf, Ceklist Terlebih dahulu !');
				}
				
				if(name == "" || username == "" || email == "" || password == ""){
					alert('Maaf data masih kosong !!');
				}else if(password != retype){
					alert('Maaf konfirmasi password salah !!');
				}else{
					$("#frmRegister").submit(); // submit form data
				}
				
				return false;
			});
		});
	</script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>