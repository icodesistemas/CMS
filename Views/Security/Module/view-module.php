<script>
	$(document).ready(function(){
		$("#ubicacion").change(function(){
			$("#action").removeAttr("name");
			$("#form-module").submit();
		})
		<?php
			if(isset($_REQUEST["ubicacion"])){ ?>
        		$("#ubicacion option[value=<?= $_REQUEST["ubicacion"] ?>]").attr("selected",true);	
        		
        <?php } ?>
        $("#button-save").live("click",function(){
        	if($("#ubicacion").val() == ""){
        		MsjUser("Debe Seleccionar una ubicación para la opción ");	

        	}else{
        		validateFormFields("form-module");	
        	}
        	
        });
        $("#button-edit").live("click",function(){
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
				MsjUser("Debe seleccionar un Módulo de la lista");
				
				return;
			}
			location.href = '/Security/Module/view-module?frm=add-module&sid=<?= $_SESSION["sid"] ?>&option=data-edit-module&module-indx='+valor;
        });
        $("#button-delete").live("click",function(){
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
				MsjUser("Debe seleccionar un Módulo de la lista");
				
				return;
			}
			if(confirm("¿Desea eliminar la opción de sistema selecionado?")){
				location.href = '/Security/Module/view-module?ubicacion=<?=$_REQUEST["ubicacion"]?>&sid=<?= $_SESSION["sid"] ?>&action=delete-module&module-indx='+valor;	
			}
			

        })
    })
</script>
<?php
	if(!isset($_REQUEST["frm"])){
		require_once "list-module.php";
	}else{
		require_once $_REQUEST["frm"].".php";
	}
	
?>

