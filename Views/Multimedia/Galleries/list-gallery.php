<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Multimedia/Galleries/create-gallery'
		});
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
		$("#button-edit").live("click",function(){
			actionButton('edit');
        });
        $('#button-delete').live("click",function(){
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
			MsjUser("Debe seleccionar un Slider de la lista");			
			return;
		}
		if(btn == "edit"){
			location.href = '/Multimedia/Galleries/view-galleries?option=data-gallery&frm=create-gallery&indx='+valor+'&sid=<?=$_SESSION["sid"]?>';
		}else if(btn == "delete"){
			location.href = '/Multimedia/Galleries/view-galleries?sid=<?= $_SESSION["sid"] ?>&action=delete-gallery&indx='+valor;
		}else if(btn == "block"){
//			location.href = '/Content/Adm/general-article?sid=<?= $_SESSION["sid"] ?>&action=disabled-article&section-indx='+valor;
		}
		else if(btn == "unlock"){
			location.href = '';
		}
	}
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>"><br>
<?php
	$pag = array(
				"filter" => "slider_name",
				"header" => array("Código","Descripción","Tipo","Estatus"),
				"DB"     => array("select" => "gal_cod, gal_name,gal_type,(case when gal_status = 1 then 'Activado' when gal_status = 0 then 'Inhabilitado' end) as estatus",
					              "from" => "tb_gallery"),
				"request" =>'/Multimedia/Galleries/view-galleries'
			);
	Component::paginacion($pag);
?>					
</form>