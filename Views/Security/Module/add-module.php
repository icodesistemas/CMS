<?php
	if(isset($_REQUEST["option"])){
		$action = "edit-module";
	}else{
		$action = "add-module";
	}
?>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Security/Module/view-module" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Security/Module/view-module?frm=add-module" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form id = "form-module" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
	<section style="width:49%;float:left">
		<fieldset>
			<legend>Propiedades de la Opción</legend>
			<p>
				<label>Estilo CSS para icono spray</label>
				<input type="text" name="ico-css" value="<?= $_REQUEST["ico-css"] ?>" autofocus="on">
			</p>
			<p>
				<label>Título de la Opción</label>
				<input type="text" name="titulo" value="<?= $_REQUEST["titulo"] ?>"  placeholder = "Breve descripción que se mostrará al ingresar en la opción">
			</p>
			<p>
				<label>Ubicación de la Opción</label>
				<select name="ubicacion" id = "ubicacion">
					<option value="0"></option>
					<option value="S">Menú Superior</option>
					<option value="L">Menú Lateral</option>
				</select>
			</p>
		</fieldset>

	</section>
	<section style="width:49%;float:right">
		<fieldset>
			<legend>Estructura para Crear la URL</legend>
			<p>
				<label>Nombre del Modulo</label>
				<input type="text" required="required" value="<?= $_REQUEST["modulo"] ?>" name="modulo" placeholder="Modulo y Opcion del Sistema" >
			</p>
			<p>
				<label>Modulo</label>
				<input type="text"  name="direct" value="<?= $_REQUEST["direct"] ?>" placeholder="Modulo Principal" >
			</p>
			<p>
				<label>Sub - Modulo</label>
				<input type="text" name="submodulo" value="<?= $_REQUEST["submodulo"] ?>" placeholder="Sub -Modulo" >
			</p>
			<p>
				<label>Vista</label>
				<input type="text" name="view" value="<?= $_REQUEST["view"] ?>" placeholder="Nombre de la Vista PHP" >
			</p>
			<p>
				<label>Accion</label>
				<input type="text" name="accion" value="<?= $_REQUEST["accion"] ?>" placeholder="Accion que se Ejecuta en la Vista" >
			</p>
			<p>
				<label>Modulo Padre</label>
				<select id="modduloPadre" name="modduloPadre">
					<option value="0">Raíz</option>
					<?php
						echo Funciones::getComboModule($_REQUEST["ubicacion"]);
					?>
				</select>
			</p>	
			<div class="clear"></div>
		</fieldset>
	</section>

	<input type="hidden" name = "action" id = "action" value="<?= $action ?>" />		
	<input type="hidden" name = "sid" value="<?= $_SESSION["sid"] ?>">
</form>