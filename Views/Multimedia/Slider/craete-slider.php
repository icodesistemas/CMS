<?php
	if(!isset($_REQUEST["action"])){
		$_REQUEST["action"] = "add-slider";
	}
?>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Multimedia/Slider/view-slider" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Content/Adm/create-article" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form id = "frm_slider" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>" >
	<section style = "float:left; width:70%; position:relative">
		<p style="width:85%">
			<label>Nombre:</label>
			<input type="text" name="nombre" placeholder = "Nombre descriptivo del Slider" value="<?= $_REQUEST["slider_name"] ?>">
		</p>
		<input type = "button" id = "insertar-campos" value="Insertar Archivo">
		<p style="position:absolute; right:0; top:0">
			<label>Slider Activado</label>
			<select name="status" id = "status">
				<option value="1">SI</option>
				<option value="0">NO</option>
			</select>
		</p>

		<p style="margin-top:20px">
			<table class = "Grid" id = "gallery-files">
				<thead>
					<tr>
						<th>Archivo</th>
						<th>Ruta del Archivo</th>
						<th>Url Destino</th>
						<th>Descripción del Archivo</th>
						<th>Creditos</th>
						<th></th>
					</tr>
				</thead>
				<?php
					echo Apollo::$CC->getFileSlider();
				?>
			</table>
		</p>	
	</section>
	<section style = "float:right; width:29%;">
		<h3 style="margin-top:0">Visible en las siguientes secciones:</h3>
		<table class = "Grid"  style="margin-top:20px">
			<thead>
				<tr>
					<th>Secciones de la Página</th>
				</tr>	
			</thead>
		<?php
			Apollo::$CC->getListSection();
		?>
		</table>		
	</section>
	<div class="clear"></div>
	<input type="hidden" name="action" value="<?= $_REQUEST["action"] ?>">
	<input type="hidden" name="idSlider" value="<?= $_REQUEST["slider_cod"] ?>">
	<input type="hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
</form>