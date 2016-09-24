<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
			location.href = '/Tmp-Struct/Section/general-section?frm=create-section'
		});
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
	})
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>"><br>
<?php
	$pag = array(
				"filter" => "name_section",
				"header" => array("Código","Sección","Descripción","URL", "¿Principal?","Status","Sección padre"),
				"DB"     => array("select" => "cod_section, name_section_".$_SESSION["idioma"].", descrip_section_".$_SESSION["idioma"].",section_url_".$_SESSION["idioma"].",
											   (case when main_section = 1 then 'SI' when main_section = 0 then 'NO' end) as principal,
											   (case when active_section = 1 then 'Activida' when active_section = 0 then 'Inhabilitada' end) as status,
											   (select name_section_".$_SESSION["idioma"]." from tb_section where a.cod_section_parent = cod_section) as padre",
					              "from" => "tb_section a ",
					              "where" =>"cod_language = '".$_SESSION["idioma"]."' " ),
				"request" =>'/Tmp-Struct/Section/general-section?frm=list-section'
			);
	Component::paginacion($pag);
?>					
</form>