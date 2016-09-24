<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
				location.href = '/Security/User/view-user?frm=add-user'
			})
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
	})
</script>
<section id="toolBar" class = 'opc-menu'></section>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>">
	<?php
		//$cb1 = $app->Fun->getCombo("perfiles","id_perfil,name_perfil");
		$pag = array(
				"filter" => "nomuser",
				"header" => array("Código","Nombre de Usuario","Identicación de Ingreso","Perfil","Status"),
				"DB"     => array("select" => "coduser,nomuser,usersession,name_profile,(case when status = 'A' then 'Activo' when status = 'I' then 'Bloqueado' end) as status",
					              "from" => "tb_user a, tb_profiles b",
					              "where" => "cod_profile = codperfil" ),
				"request" =>'/Security/User/view-user'	
			);
		Component::paginacion($pag);
	?>
</form>
