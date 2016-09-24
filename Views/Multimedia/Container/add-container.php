<br><br><form method="post" action="<?= $_SERVER["REQUEST_URI"] ?>&frm=add-container" id="frmCluseter" method = "post">
<section class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#tabs-1">Crear contenedor multimedia</a>
		</li>		
	</ul>
	<section class="tab-content">
		<div id="tabs-1" class="tab-pane active">
			<p>
				<label>Nombre del Contenedor</label>
				<input type = "text" required = "required" name="name-cluster">
			</p>
			<p>
				<label>Fecha de creación</label>
				<input type = "text" required = "required" value = "<?= date("Y-m-d") ?>" readonly= "readonly">
			</p>
		</div>		
	</section>
</section>		
	<input type="hidden" name="cluster" id="cluster-father" value = "">
	<input type="hidden" name="action" value="create-cluster">
	<input type="hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
	<div class="clear"> </div>
</form>