<script src="/Template/js/jquery.treeview.js"></script>
<script>

	$(document).ready(function(){
		$("#button-save").live('click',function(){
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
				MsjUser("Debe seleccionar las opciones a las cuales el nuevo perfil tendra acceso");				
				return;
			}
			if($("#perf").val().trim() == ""){
				MsjUser("Debe ingresar un nombre para el nuevo perfil");				
				return;	
			}
			$("#form-perfil").submit();
		});
		$("#button-delete").live( "click", function() {
			var chck = false;
			var valor = ""
			$('td>input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });

			if(!chck){
				MsjUser("Debe seleccionar un perfil de la lista");
				
				return;
			}
			location.href = '/Security/Profile/view-profile-user?sid=<?= $_SESSION["sid"] ?>&option=delete-profile&perfil-indx='+valor;
		});
		$("#button-edit").live( "click", function() {
			var chck = false;
			var valor = ""
			$('td>input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });

			if(!chck){
				MsjUser("Debe seleccionar un perfil de la lista");
				
				return;
			}
			location.href = '/Security/Profile/view-profile-user?sid=<?= $_SESSION["sid"] ?>&option=get-profile&perfil-indx='+valor;
		});
		<?php
			if(isset($_REQUEST["option"]) && $_REQUEST["option"] == 'get-profile'){
		?>
				$("#Form_Edit_Perfil").modal("show");
		<?php } ?>
	})	
</script>
	
	<?php
		if(!isset($_REQUEST["frm"])){
			require_once ("list-profile.php");
		}else{
			require_once $_REQUEST["frm"].".php";
		}
		
	?>

