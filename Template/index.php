<!DOCTYPE html>
<html>
	<head>
	<meta charset='UTF-8'>
	<meta name="robots" content="NOINDEX, NOFOLLOW" />
	<link rel="shortcut icon" type="image/x-icon" href="/Template/img/favi.jpg">
	<meta name="author" content="Angel Bejarano / programador.angel@gmail.com " />

	<link rel="stylesheet" type="text/css" href="/Template/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/Template/css/style-form.css">
	<link rel="stylesheet" type="text/css" href="/Template/css/style.css">
	
	<script src="/Template/js/jquery.js"></script>
	<script src="/Template/js/bootstrap.min.js"></script>	
	<script src="/Template/js/bootstrap-datetimepicker.min.js"></script>	
	<script src="/Template/js/locales/bootstrap-datetimepicker.es.js"></script>	
	<script src="/Template/js/jquery.apollo.js"></script>

	<title>SafeSigma - Panel</title>

	<script>
		$(document).ready(function(){

			if($(".msj-user").text().trim()== ""){
				$(".msj-user").css("display","none");
			}else{
				$(".msj-user").fadeIn("slow");
				$(".msj-user").fadeOut(6000);
			}
		});
	</script>	
</head>
<body>
	<section class="section-main">
		<div id = "datos" class= "modal hide fade in" style = "width:80%">
			<div class = "modal-header">
				<a data-dismiss="modal" class="close">×</a>
				<h3>Explorador de Archivos</h3>
			</div>
			<div class = "modal-body" id = "exploradorArchivo">
				
			</div>
		</div>
		<section class = "loading">
			<center><img src="/Template/img/loading.gif">
			</center>
		</section>
		<?php
			require_once Apollo::getView();
		?>
	</section>
</body>
</html>
