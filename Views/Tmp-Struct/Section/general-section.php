
<script>
	$(document).ready(function(){		
		$("#addArea").live("click",function(){
			$(".loading").hide();
			if($("#name-area").val().trim() == ""){
				alert("DEBE INGRESAR LOS DATOS DEL AREA");
				return;
			}
			var xhtml = '<tr>'+
							'<td><input type="hidden" name="area[]" value = "'+$("#name-area").val()+'">'+$("#name-area").val()+'</td>'+
							'<td><input type="hidden" name="ancho[]" value = "'+$("#width-area").val()+'">'+$("#width-area").val()+'</td>'+
							'<td><input type="hidden" name="tipo_contenido[]" value = "'+$("#type-content").val()+'">'+$("#type-content").val()+'</td>'+
							'<td><input type="hidden" name="style[]" value = "'+$("#css").val()+'">'+$("#css").val()+'</td><td></td>'+
						'</tr>';
			$("#areas").append(xhtml);		
			$("#name-area").val("");
			$("#width-area").val("");
			$("#type-content").val("");
			$("#name-area").focus();
		});
		$("#button-save").click(function(){

			validateFormFields("form-section");	
		});
		$("#button-edit").live("click",function(){
			actionButton('edit');
        });
        $("#button-delete").live("click",function(){
			actionButton('delete');
        });
        $("#button-block").live("click",function(){
			actionButton('block');
        });
        $("#button-unlock").live("click",function(){
			actionButton('unlock');
        });

	})
	function deleteArea(indxSection,indxArea){
		if(confirm("¿Desea eliminar el área?")){
			location.href = "/Tmp-Struct/Section/general-section?frm=create-section&sid=<?= $_SESSION["sid"] ?>&option=data-edit-section&section-indx="+indxSection+"&action=delete-area&indx-area="+indxArea+"";	
		}
		
	}
	function actionButton(btn){
		var chck = false;
		var valor = "";
		$('td>input[type=checkbox]').each( function() { 	        	
            if($(this).is(':checked')){
            	if($(this).val() != 0){
            		chck = true;
            		valor = $(this).val();	            		
            	}
            }
        });
		if(!chck){
			MsjUser("Debe seleccionar una Sección de la lista");			
			return;
		}
		if(btn == "edit"){
			location.href = '/Tmp-Struct/Section/general-section?frm=create-section&sid=<?= $_SESSION["sid"] ?>&option=data-edit-section&section-indx='+valor;
		}else if(btn == "delete"){
			location.href = '/Tmp-Struct/Section/general-section?sid=<?= $_SESSION["sid"] ?>&action=delete-section&section-indx='+valor;
		}else if(btn == "block"){
			location.href = '/Tmp-Struct/Section/general-section?sid=<?= $_SESSION["sid"] ?>&action=disabled-section&section-indx='+valor;
		}
		else if(btn == "unlock"){
			location.href = '/Tmp-Struct/Section/general-section?sid=<?= $_SESSION["sid"] ?>&action=enabled-section&section-indx='+valor;
		}
	}
</script>
<?php
	if(!isset($_REQUEST["frm"])){
		require_once "list-section.php";
	}else{
		require_once $_REQUEST["frm"].".php";
	}
?>