<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Multimedia/Slider/view-slider?frm=add-slider'
		});
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
		$("#button-edit").live("click",function(){
			actionButton('edit');
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
			location.href = '/Multimedia/Slider/view-slider?option=data-slider&indx='+valor+'&sid=<?=$_SESSION["sid"]?>';
		}else if(btn == "delete"){
			location.href = '';
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
				"filter" => "slider_name_".$_SESSION["idioma"]."",
				"header" => array("Código","Descripción","Estatus"),
				"DB"     => array("select" => "slider_cod, slider_name_".$_SESSION["idioma"].",(case when slider_status = 1 then 'Activado' when slider_status = 0 then 'Inhabilitado' end) as estatus",
					              "from" => "tb_sliders"),
				"request" =>'/Multimedia/Slider/view-slider'
			);
	Component::paginacion($pag);
?>					
</form>