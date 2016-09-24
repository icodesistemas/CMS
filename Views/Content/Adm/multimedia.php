<section style = "float:left; width:49%;">
	<label>Imagen miniatura</label>
	<input type = "text" id = "search-file" name="miniatura" readonly="readonly" value="<?= $_REQUEST["art_thumbnail"] ?>">
	<?php
		if(isset($_REQUEST["art_thumbnail"]) && !empty($_REQUEST["art_thumbnail"])){
			echo "<h3>Vista previa</h3>
			<img src = '".$_REQUEST["art_thumbnail"]."'>
			";
		}
	?>
</section>
<section style = "float:right; width:49%;">
	<label>Imagen Principal</label>
	<input type = "text" id = "search-file" name="principal" readonly="readonly" value="<?= $_REQUEST["art_img_main"] ?>">
	<?php
		if(isset($_REQUEST["art_thumbnail"]) && !empty($_REQUEST["art_thumbnail"])){
			echo "<h3>Vista previa</h3>
			<img src = '".$_REQUEST["art_img_main"]."' width='100%'>
			";
		}
	?>
</section>

<div class = "clear"></div>
<hr>

<section style = "width:20%;float:left; margin-left:10px;">
	
	<h3 style="margin-bottom:0">Galerías creadas</h3><hr>
	<p class="inline">		
		<select name="galeria-creadas" id = "galeriaCreadas">
			<option value="0">-- Seleccion un Galeria Existente --</option>
			<?php
				echo Funciones::getCombo("tb_gallery","gal_cod,gal_name");
			?>>
		</select>
	</p>
</section>
<section style = "float:right; width:50%; position:relative">
	<h3 style="margin-bottom:0">Crear una nueva galería</h3><hr>	
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
		<input type="text" name="nombre-galeria" placeholder = "Nombre descriptivo de la galeria">
	</p>
	<p class="inline" style=" width:49%; float:left">
		<label>Estatus</label>
		<select name="status-galeria">
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
		
	</table>
</p>
