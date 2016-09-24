<?php
	if(!isset($_REQUEST["action"])){
		$_REQUEST["action"] = "add-gallery";
	}
?>
<script>
	$(document).ready(function(){
		$("#button-save").live("click",function(){
			$("#frm_gallery").submit();
		});
		<?php
			if(isset($_REQUEST["gal_status"])){
				echo '$("#status-galeria option[value='.$_REQUEST["gal_status"].']").attr("selected",true);';
			}
			if(isset($_REQUEST["gal_type"])){
				echo '$("#tipo_galeria option[value='.$_REQUEST["gal_type"].']").attr("selected",true);';
			}
		?>
	})
</script>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Multimedia/Galleries/view-galleries" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Multimedia/Galleries/view-galleries?frm='create-gallery'" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form id = "frm_gallery" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>" >
	<section style = " width:50%; position:relative">			
		<p class="inline" style=" width:49%; float:left">
			<label>Tipo de Galería</label>
			<select name="tipo_galeria" id = "tipo_galeria">
				<option></option>
				<option value = "Imagen">Imagen</option>
				<option value = "Audios">Audios</option>
				<option value = "Videos">Videos</option>
				<option value = "Descargables">Descargables</option>
			</select>
		</p>
		<p class="inline" style=" width:49%; float:left">
			<label>Nombre de la galería</label>
			<input type="text" name="nombre-galeria" placeholder = "Nombre descriptivo de la galeria" value="<?= $_REQUEST["gal_name"] ?>">
		</p>
		<p class="inline" style=" width:49%; float:left">
			<label>Estatus</label>
			<select name="status-galeria" id = "status-galeria">
				<option value="1">Activada</option>
				<option value="0">Inactiva</option>
			</select>
		</p>
		<p class="inline" style=" width:49%; float:left; margin-top:20px;">
			<input type = "button" id = "insertar-campos" value="Insertar Archivo" style = "float:right;">
		</p>
		<div class = "clear"></div>
	</section>
	<div class="clear"></div>

	<div class="clear"></div>
	<p>
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
				Apollo::$CC->getFileGallery();
			?>
		</table>
	</p>
	<input type="hidden" name="action" value="<?= $_REQUEST["action"] ?>">
	<input type="hidden" name="idGallery" value="<?= $_REQUEST["gal_cod"] ?>">
	<input type="hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
</form>	
