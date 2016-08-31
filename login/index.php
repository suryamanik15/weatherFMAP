<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>CuacaKu - Portal Ramalan dan Forecasting Cuaca Medan dan Sekitarnya</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/custom.css">
  </head>

  <body>
<div id="clouds">
	<div class="cloud x1"></div>
	<!-- Time for multiple clouds to dance around -->
	<div class="cloud x2"></div>
	<div class="cloud x3"></div>
	<div class="cloud x4"></div>
	<div class="cloud x5"></div>
</div>

 <div class="container">


      <div id="login">

        <form method="post" id='formLogin' action="">

          <fieldset class="clearfix">

            <p><span class="fontawesome-user"></span><input type="text" name="username" id="txtUsername" placeholder="Username.."></p> <!-- JS because of IE support; better: placeholder="Username" -->
            <p><span class="fontawesome-lock"></span><input type="password" name="password" id="txtPassword" placeholder="Password.."></p> <!-- JS because of IE support; better: placeholder="Password" -->
            <p><input type="submit" value="Log In" id="btnSubmit"></p>

          </fieldset>

        </form>

        <p><a href="">Belum Terdaftar ? </a>
		<a href="#" class="blue">Daftarkan</a><span class="fontawesome-arrow-right"></span></p>

      </div> <!-- end login -->

    </div>
    <div class="bottom">
		<code style='color:white;font-size:12px;font-family:verdana;'>
			Selamat datang di Portal Aplikasi Forecasting dan Peramalan Keadaan Cuaca Medan dan Sekitarnya
		</code>
		<h3><a href="">Portal CuacaKu</a></h3>
	</div>
	
    <script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>	
	<script type="text/javascript">
		$body = $("body");

	    $(document).on({
					 ajaxStart: function() { $body.addClass("loading");    },
					 ajaxStop: function() { $body.removeClass("loading"); }    
		});
		
		$("#btnSubmit").click(function(){
			var username = $("#txtUsername").val();
			if(username == ""){
				alert("Maaf, username masih kosong !!");
				return false;
			}
		});
	</script>
  </body>
</html>
