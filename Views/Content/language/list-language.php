<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Content/language/create-language'
		});
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
		$("#button-edit").live("click",function(){
			actionButton('edit');
        });
        $("#button-delete").live("click",function(){
			actionButton('delete');
        });
	})
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
			location.href = '/Content/language/create-language?option=data-language&indx='+valor+'&sid=<?=$_SESSION["sid"]?>';
		}else if(btn == "delete"){
			if(confirm('¿Desea eliminar el articulo?')){
				location.href = '/Content/language/list-language?sid=<?= $_SESSION["sid"] ?>&action=delete-language&language-indx='+valor;
			}
			
		}
	}
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>"><br>
<?php

	$pag = array(
				"filter" => "language",
				"header" => array("Código","Codigo","Descripcion","Estatus"),
				"DB"     => array("select" => "cod_language,cod_language,language, (case when status = 'A' then 'ACTIVO' when status = 'I' then 'INACTIVO' end) as estatus",
					              "from" => "tb_idiomas"),
				"request" =>'/Content/language/list-language'
			);
	Component::paginacion($pag);
?>					
</form>