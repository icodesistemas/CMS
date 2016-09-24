<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Tmp-Struct/Section/general-section" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Tmp-Struct/Section/general-section?frm=create-section" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form action="<?= $_SERVER["REQUEST_URI"] ?>" method = "post" id = "form-section">

	<section style = "width:70%; float:left;">
		<p>
			<label>Seccion</label>
			<input type="text" required = "required" name="seccion" value="<?= $_REQUEST["seccion"] ?>" placeholder = "Nombre o Título de la Sección" autofocus = "on"> 
		</p>
		<p>
			<label>Título</label>
			<input type="text" required = "required" name = "titulo" value="<?= $_REQUEST["titulo"] ?>" placeholder = "Título de la sección">
		</p>
		<p>
			<label>Descripción</label>
			<input type="text" required = "required" name = "descrip" maxlength="200" value="<?= $_REQUEST["descrip"] ?>" placeholder = "Descripcion de la razon de la sección">
		</p>
		<section style = "float:left; width:20%;margin-right:40px">
			<p>
				<label>URL</label>
				<input type = "text" name="URL" value="<?= $_REQUEST["section_url"] ?>">
			</p>
		</section>			
		<section style = "float:left; width:20%;">
			<p>
				<label>Abrir URL en:</label>
				<select name="open-URL">
					<option value="">Misma Ventana</option>
					<option value= "_blank">Otra Venta</option>
				</select>
			</p>
		</section>		
		<div class = "clear"></div>
	</section>
	<section style = "width:30%; float:right;">		
		<fieldset>
			<legend>Atributos</legend>
			<p>
				<label>Sección Padre</label>
				<select id="idPadre" name="idPadre" required = "required">
					<option value="0">/ Raiz</option>
					<?php
					
						echo Funciones::getComboSection();
					?>
				</select>
			
			</p>
			<p style="width:40%; float:left;">
				<label>Principal</label>
				<select name="main" id = "main">
					<option value="1">SI</option>
					<option value="0">No</option>
				</select>
			</p>
			<p style="width:40%; float:left; margin-left:20px">
				<label>Sección Activa</label>
				<select name="estado" id = "estado" required = "required">
					<option value 	= "0">NO</option>
					<option value = "1">SI</option>
				</select>
			</p>
			<p style="width:40%; float:left;">
				<label>Imagen de fondo</label>	
				<input type="text"  name="img-fondo" value="<?= $_REQUEST["background"] ?>" id="search-file" data-preview="1">
			</p>
			<div class="clear"></div>			
			
		</fieldset>
	</section>
	<div class="clear"></div>
	<!--<fieldset>
			<legend>Distribución de Zonas de la Sección</legend>
			<section id = "zonas" style = "position:relative	">		
				<section class = "define-area">
					<p style="width:20%; float:left">
						<label>Zonas</label>
						<input type = "text" id = "name-area" value = ""  placeholder = "Nombre de la Zona">	
					</p>
					<p style="width:20%; float:left; margin-left:20px;">
						<label>Ancho de la Zona(Porcentaje)</label>
						<input type = "number" id = "width-area" value = "" placeholder = "">	
					</p>
					<p style="width:20%; float:left;margin-left:20px;">
						<label>Tipo de Contenido a Mostrar</label>
						<select id="type-content">
							<option></option>
							<?php
								echo Funciones::getCombo("tb_type_content","cod_type_content,type_content","active = 1");
							?>
						</select>
					</p>
					<p style="width:20%; float:left;margin-left:20px;">
						<label>Selector CSS</label>
						<input type="text" name="css" id = "css" placeholder = "Estilo CSS que regirá a la Zona">
					</p>
					<p style=" position: absolute;right: -140px;top: 20px;width: 18%;">
						<a href="#" class="button" id="addArea">
							<span class="ico-button ico-user-add"></span>
							<i>Nuevo</i>
						</a>
					</p>
					<div class="clear"></div>
				</section>	
				<table width="100%" id = "areas">
					<thead>
						<tr>
							<th>Nombre de la Zonas</th>
							<th>Procentaje de Ancho</th>
							<th>Tipo de Contenido</th>
							<th>Estilo del Área</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?= $app->MM->getAreas() ?>
					</tbody>
				</table>
			</section>
		</fieldset>	-->
	<input type="hidden" name = "sid" value="<?= $_SESSION["sid"] ?>">
	<input type="hidden" name = "action" value="<?= $_REQUEST["action"] ?>" >
</form>		
<script>
	
	<?php
		if(isset($_REQUEST["estado"])){
			echo '$("#estado option[value='.$_REQUEST["estado"].']").attr("selected",true);  ';
		}
		if(isset($_REQUEST["main"])){
			echo '$("#main option[value='.$_REQUEST["main"].']").attr("selected",true);  ';
		}
		if(isset($_REQUEST["cod_section_parent"])){
			echo '$("#idPadre option[value='.$_REQUEST["cod_section_parent"].']").attr("selected",true);  ';
		}
	?>
</script>