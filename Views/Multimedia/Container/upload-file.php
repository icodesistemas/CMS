<br><br>
<form id = "frm-upload" enctype="multipart/form-data" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Subir Archivos al Servidor</a>
			</li>		
		</ul>
		<section class="tab-content">
			<div id="tabs-1" class="tab-pane active">
				<p>
					<label>Nombre del Archivo</label>
					<input type="text" name="descripcion" id="descripcion" placeholder="El archivo sera renombrado por lo que escriba en este campo">
				</p>
				<p>
					<label>Tipo de Archivo</label>
					<select name="tipo_archivo" id="tipo_archivo" class="field size1">
						<option value="">--Seleccione el tipo de archivo--</option>
						<optgroup label="Documentos">
							<option value="Word">Word</option>				
							<option value="Excel">Excel</option>
							<option value="PowerPoint">PowerPoint</option>
							<option value="PDF">PDF</option>	
						</optgroup>
						<optgroup label="Multimedia">			
							<option value="Imagen">Imagen</option>
							<option value="Audio">Audio</option>
							<option value="Videos">Video</option>
						</optgroup>
						
					</select>
				</p>	
				<div id="fileName"></div>
			    <div id="fileSize"></div>
			    <div id="fileType"></div>
			</div>
		</section>	
		<input type="file" name="archivo" id="fileToUpload" onchange="fileSelected();">
	</section>		<br>
	<center>

		<button>SUBIR ARCHIVO</button>		
	</center>
	<input type = "hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
	<input type="hidden" name="action" value="upload-file">
	<input type="hidden" name="container" id="upload-container">
	<input type="hidden" name="type_file" id="type_file">
</form>
