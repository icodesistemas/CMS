<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Content/Adm/create-article'
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
        $("#button-block").live("click",function(){
			actionButton('block');
        });
        $("#button-unlock").live("click",function(){
			actionButton('unlock');
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
			location.href = '/Content/Adm/create-article?option=data-article&indx='+valor+'&sid=<?=$_SESSION["sid"]?>';
		}else if(btn == "delete"){
			if(confirm('¿Desea eliminar el articulo?')){
				location.href = '/Content/Adm/general-article?sid=<?= $_SESSION["sid"] ?>&action=delete-article&section-indx='+valor;
			}
			
		}else if(btn == "block"){
			location.href = '/Content/Adm/general-article?sid=<?= $_SESSION["sid"] ?>&action=disabled-article&section-indx='+valor;
		}
		else if(btn == "unlock"){
			location.href = '/Content/Adm/general-article?sid=<?= $_SESSION["sid"] ?>&action=enabled-article&section-indx='+valor;
		}
	}
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>"><br>
<?php
	$pag = array(
				"filter" => "art_title",
				"header" => array("Código","Título","URL","Autor","Fecha Publicación","Publicado"),
				"DB"     => array("select" => "art_cod,art_title_".$_SESSION["idioma"].",art_url_".$_SESSION["idioma"].",nomuser,art_date_published,art_status",
					              "from" => "tb_article a, tb_user b", 
					              "where" => "coduser = art_creator"),
				"request" =>'/Content/Adm/general-article'
			);
	Component::paginacion($pag);
?>					
</form>