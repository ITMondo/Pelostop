<?php

		session_start();
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		define('HOSTNAME_CONEXION','localhost');
		define('USERNAME_CONEXION','dev_hyundai');
		define('PASSWORD_CONEXION','K27j3By5');
		define('DATABASE_CONEXION','dev_hyundai');

		$db = new mysqli(HOSTNAME_CONEXION, USERNAME_CONEXION, PASSWORD_CONEXION, DATABASE_CONEXION);
		if($db->connect_errno > 0){
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
		$db->set_charset('utf8');
		
		
		
		
		function generaPass(){
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			$longitudCadena=strlen($cadena);
			$pass = "";
			$longitudPass=5;
			 
			for($i=1 ; $i<=$longitudPass ; $i++){
				$pos=rand(0,$longitudCadena-1);
				$pass .= substr($cadena,$pos,1);
			}
			return $pass;
		}

		$models = array(
		'i10' => array('id'=>'i10','des'=>'i10'),
		'i20' => array('id'=>'i20','des'=>'i20'),
		'i30' => array('id'=>'i30 2017','des'=>'i30'),
		'i40' => array('id'=>'i40','des'=>'i40'),
		'ioniq' => array('id'=>'IONIQ','des'=>'IONIQ'),
		'santa-fe' => array('id'=>'Santa Fe','des'=>'Santa Fe'),
		'tucson' => array('id'=>'Tucson','des'=>'Tucson'),
	
		);

?>		