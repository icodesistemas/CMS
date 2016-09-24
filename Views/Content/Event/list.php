<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Content/Event/create-event'
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
			MsjUser("Debe seleccionar una Sección de la lista");			
			return;
		}
		if(btn == "edit"){
			location.href = '/Content/Event/create-event?option=data-event&indx='+valor+'&sid=<?=$_SESSION["sid"]?>';
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
				"filter" => "art_title",
				"header" => array("Código","Título","URL","Fecha del Evento","Estatus"),
				"DB"     => array("select" => "event_cod,event_title,event_url,event_date,(case when event_active = 1 then 'SI' when event_active = 0 then 'NO' end) as estatus",
					              "from" => "tb_event a"),
				"request" =>'/Content/Event/list'
			);
	Component::paginacion($pag);
?>					
</form>