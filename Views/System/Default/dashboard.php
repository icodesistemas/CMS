<header>
	<a href="/" title="Dashboard">
		<div class="logo"></div>
	</a>	
	<div class="nav-collapse">
		<?= $app->systemTopMenu(); ?>		
	</div>
	<div class="user">
		<?= Login::$datSession["nombre"]; ?>	
	</div>
	<div class="clear"></div>
	<section class="mini-header">
		<?= Apollo::$titleOpcRun ?>
		
		<section class="msj-user">
			<?= $app->getMsjUser() ?>
		</section>
	</section>

</header>
<section class = "sidebar">
	<?= $app->systemSideMenu(); ?>	
</section>

<section class =  "body">
	<?php
		require_once $app->getFileView();
	?>
</section>