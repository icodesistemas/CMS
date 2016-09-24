<?php
	if(isset($_REQUEST["option"])){
		$rs = $app->MM->getDataUser();
		$action = "update-user";	
		$readonly = 'readonly="readonly"';
	}else{
		$action = "add-user";
	}
	
	
?>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Security/User/view-user" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Security/User/view-user?frm=add-user" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section>
<form method="post" id = "form-add-user" action="<?= $_SERVER["REQUEST_URI"] ?>">

	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Datos de la Cuenta</a>
			</li>
			<li>
				<a data-toggle="tab" href="#tabs-2">Perfil Asignar</a>
			</li>		
		</ul>
		
		<section class="tab-content">
			<div id="tabs-1" class="tab-pane active">
				<p>
					<label>Nro. Identificación</label>
					<input type="number" <?= $readonly ?> value="<?= $rs["coduser"] ?>" autofocus = "on" id = "ciUser"  name="ciUser" required="required" placeholder="Documento de Identificacion" autocomplete="off" >
				</p>
				<p>
					<label>Nombre y Apellido</label>
					<input type="text" value="<?= $rs["nomuser"] ?>" name="nameUser" id="nameUser" required="required" autocomplete="off" >
				</p>
				<p>
					<label>Nombre de Acceso</label>
					<input type="text"  value="<?= $rs["usersession"] ?>" name="user" placeholder = "Identificación para ingresar al sistema" required="required" autocomplete="off" >
				</p>
				<p>
					<label>Correo Electronico</label>
					<input type="email"  value="<?= $rs["emailuser"] ?>" placeholder = "Dirección de Correo Electronico" name="emailUser" required="required" autocomplete="off" >
				</p>
				<fieldset>
					<legend>Contraseña</legend>
					<p style="width:44%; float:left">
						<input type="password" placeholder = "Ingrese su Contraseña de Acceso" name="passUser" id = "passUser" autocomplete="off" >
					</p>
					<p style="width:44%; float:right">
						<input type="password" placeholder = "Confirmar Contraseña de Acceso" name="passRepet" id = "passRepet" autocomplete="off" >
					</p>
					<div class="clear"></div>
				</fieldset>
				
			</div>
			<div id="tabs-2" class="tab-pane">
				<?php
					echo $app->MM->getProfiles();
				?>
			</div>
		</section>					
	</section>
	<input type="hidden" name="action" id= "action" value="<?= $action ?>" />
	<input type="hidden" name ="sid" value="<?= $_SESSION["sid"] ?>">
	<div class="clear"></div>
</form>