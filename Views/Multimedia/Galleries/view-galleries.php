
<?php
	if(!isset($_REQUEST["frm"])){
		require_once "list-gallery.php";
		return true;	
	}else{
		require_once $_REQUEST["frm"].".php";
		return true;
	}
?>
<h1>VISTA NO EXISTE</h1>