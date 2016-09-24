<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
				location.href = '/Security/Profile/view-profile-user?frm=add-profile'
			})
		$("#toolBar").Apollo({
			button:'add,edit,delete,filter'
		});
	})
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br><br>
<form id="tabla" class="bloque">
	<?php
		$pagination = array(
			"header" => array('',"Identificación del Perfil"),
			"DB"     => array("select"=>"cod_profile,name_profile",
				              "from" => "tb_profiles" ),
			"action" => array("update" => "Actualizar",
							  "delete" => "Eliminar" 
							 ),
			"request" =>'/Security/Profile/view-profile-user'	
			);
		Component::paginacion($pagination);
		
	?>
</form>

<form title="Editar Perfil de Usuarios" id="Form_Edit_Perfil" class="modal hide fade in" method="post" action="/Security/Profile/view-profile-user">
	<input type="hidden" name="idPerfil" id="idPerfil" />
	<section class="modal-header">
		<a data-dismiss="modal" class="close">×</a>
		<h3>EDITAR PERFIL</h3>
	</section>
	<section id="formulario-editar">
		<?php
			Apollo::$CC->getProfiles(true);
		?>
	</section>
	<div class="linea"></div>
	<input type="hidden" name="action" value="edit-profile" />
	<input type="hidden" name="iddProfile" id="profile" value="<?= $_REQUEST["perfil-indx"] ?>" />
	<input type="hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
	<input type="submit" value="Actualizar" class="boton" />
</form>
