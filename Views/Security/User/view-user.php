<script>
	$(document).ready(function(){
		$("#button-clear").click(function(){
			$("#form-add-user")[0].reset();
			$("#ciUser").focus();
		});
		$(".id-perfil, .iTem").live({
			click: function(){
				var valor = $(this).val();
				if(!$(this).is(':checked')){
					$(this).removeAttr('checked');
					return;
				}
				$(this).attr('checked', 'checked'); 

		        $('input[type=checkbox]').each( function() { 	        	
		            if($(this).is(':checked')){
		            	if($(this).val() != valor){
		                	$(this).removeAttr('checked');
		            	}
		            }
		        }); 
			}
		})
		$("#button-save").click(function(){
			var chck = false;
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	chck = true;
	            }
	        });
	        if(!chck){
	        	MsjUser("Debe Asignar un perfil al Usuario");

	        }else{
	        	if($("#action").val() == "add-user"){
	        		if($("#passRepet").val() != $("#passUser").val()){
	        			MsjUser("Verifique la contraseña ingresada, no coinciden");	
	        			
	        			return;
	        		}else{
	        			chck = true;
	        		}
	        	}else{
	        		$("#passUser, passRepet").removeAttr("required");

	        	}
	        	validateFormFields("form-add-user");			
	        	
	        	
	        }
		});
		$("#button-edit").live( "click", function() {
			var chck = false;
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });
			if(!chck){
				MsjUser("Debe seleccionar un usuario de la lista");
				
				return;
			}
			location.href = '/Security/User/view-user?frm=add-user&sid=<?= $_SESSION["sid"] ?>&option=edit-user&indx='+valor;
		});
		$("#button-delete").live( "click", function() {
			var chck = false;
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });
			if(!chck){
				MsjUser("Debe seleccionar un usuario de la lista");
				return;
			}
			if (confirm("¿Seguro que desea eliminar el usaurio seleccionado?")) {
				location.href = '/Security/User/view-user?sid=<?= $_SESSION["sid"] ?>&action=delete-user&indx='+valor;
			}
		});
		$("#button-block").live("click",function(){
			var chck = false;
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });
			if(!chck){
				MsjUser("Debe seleccionar un usuario de la lista");
				return;
			}
			if (confirm("¿Seguro que desea bloquear al usaurio seleccionado?")) {
				location.href = '/Security/User/view-user?sid=<?= $_SESSION["sid"] ?>&action=block-user&indx='+valor;
			}
		});
		$("#button-unlock").live("click",function(){
			var chck = false;
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });
			if(!chck){
				MsjUser("Debe seleccionar un usuario de la lista");
				return;
			}
			if (confirm("¿Seguro que desea desbloquear al usaurio seleccionado?")) {
				location.href = '/Security/User/view-user?sid=<?= $_SESSION["sid"] ?>&action=unlock-user&indx='+valor;
			}
		});
		
	})

</script>
<?php
	if(!isset($_REQUEST["frm"])){
		require_once "list-user.php";
	}else{
		require_once $_REQUEST["frm"].".php";
	}
?>