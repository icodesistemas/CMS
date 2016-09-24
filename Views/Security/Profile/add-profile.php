<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Security/Profile/view-profile-user" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Security/Profile/view-profile-user?frm=add-profile" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section>
<form id = "form-perfil" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
	
	<p>
		<label>Perfil</label>
		<input type="text" name="perf" id="perf" autocomplete="off" class="input-complet" >	
	</p>
	<?php
		Apollo::$CC->getProfiles(false);
	?>
	
	<input type="hidden" name="action" value="add-profile" />
	<input type="hidden" name="sid" value="<?= $_SESSION["sid"] ?>">
	<div class="clear"></div>		
</form>
