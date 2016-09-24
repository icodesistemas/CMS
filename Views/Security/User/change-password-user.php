<script>
	$(document).ready(function(){
		$("#Form_Change_Pass").dialog({
	        autoOpen: false,
	        modal: true,
	        width: 460,
	        show: "fade",
	    	hide: "fade",
	        height: 420
	    });	
	    $("#change-key").click(function(){
	    	$("#Form_Change_Pass").dialog("open");	
	    })
	    $("#enviar").click(function(){
	    	if($("#newPass").val()!= $("#newPass2").val()){
	    		alert("la verificiacion se la clave fallo, intente nuevamente");
	    		return;
	    	}
	    	$("#load").css("display","block"); 	
			$.ajax({
		    	type: "POST",
		        url: "/Ajax/Model-Admin.php",
		        data: ({
		        	action:"change-pass",
		        	password: $("#newPass").val(),
		        	ci: $("#ci").val(),
		        	user: $("#user").val()
		        }),	
		        success: function(data) {
		        	$("#Form_Change_Pass").dialog("close");	
		        	alert(data);
		        	$("#load").css("display","none"); 	
		        	
		        }
		    });
	    })
	})
	
</script>

<form title="Cambiar Llave de Acceso" id="Form_Change_Pass" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
	<section class="bloque etiqueta">
		<label>C.I</label>
		<input type="text" name="ci" id="ci" class="input-complet" autofocus="on" autocomplete="off" placeholder="Número de Identificación del Usaurio" />
	</section>
	<section class="bloque etiqueta">
		<label>Usuario de la Cuenta</label>
		<input type="text" name="user" id="user" class="input-complet" placeholder="Usuario para Ingresar al Sistema" />
	</section>	 
	<section class="bloque etiqueta">
		<label>Ingrese su Nueva Llave</label>
		<input type="password" name="newPass" id="newPass" class="input-complet" placeholder="Nueva Llave de Acceso" />
	</section>
	<section class="bloque etiqueta">
		<label>Verifica tu Nueva Llave</label>
		<input type="password" name="newPass2" id="newPass2" class="input-complet" placeholder="Verifica Llave" />
	</section>
	<div class="clear"></div>
	<div class="linea"></div>
	<div class="clear"></div>
	<input type="button" id="enviar" value="Actualizar"  class="boton"/>
	
</form>