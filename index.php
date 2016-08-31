<?php
	ob_start();
	session_start();
	
	if(!isset($_SESSION['id_user'])){
		header('Location:public.php');
	}else{
		// do nothing
		if(!isset($_GET['data'])){
			
		}else{
		
		}
	}
	
	// end the flush
	ob_end_flush();
	