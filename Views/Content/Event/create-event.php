<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Content/Event/list" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Content/Adm/create-article" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form method="post" action="/Content/Event/create-event" id = "frm_article">
	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Crear Eventos</a>
			</li>
			<li>
				<a data-toggle="tab" href="#tabs-2">Multimedia</a>
			</li>	
			<li>
				<a data-toggle="tab" href="#tabs-3">Metadatos</a>
			</li>		
		</ul>
		<section class="tab-content">
			<div id="tabs-1" class="tab-pane active">
				<?php
					require_once "event.php";
				?>
			</div>
			<div id="tabs-2" class="tab-pane">
				<?php
					require_once $_SERVER["DOCUMENT_ROOT"]."/Views/Content/Adm/multimedia.php";
				?>
			</div>
			<div id="tabs-3" class="tab-pane">
				<?php
					require_once $_SERVER["DOCUMENT_ROOT"]."/Views/Content/Adm/metadatos.php";
				?>
			</div>
		</section>	
	</section>
	<input type = "hidden"	name = "action" value="<?= $_REQUEST["action"] ?>">
	<input type = "hidden" name = "sid" value="<?= $_SESSION["sid"] ?>">
</form>