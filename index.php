<?php
	session_start();
	ini_set("display_errors", 0);	

	ini_set('zend.enable_gc', 1);
	date_default_timezone_set('America/Caracas');	
	/* incluimos el framework */
	require_once "based-core/include-file.php";

	/* incluimos el arreglo que contine los controladores, modelos y funciones */
	require_once "conf/conf-app.php";
        
	$app = new Apollo(true);	
	$app->WebApp($conf);
	
	require_once 'Template/index.php';	
	
?>


