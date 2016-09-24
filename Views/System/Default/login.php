
<section class = "login">
<center><h2>Iniciar Sesión</h2></center>
	<form method="post" action="/">
		<p><?= $app->getMsjUser(); ?></p>
		<p>
			<label>Usuario</label>
			<input type="text" name="user" placeholder = "Identificador para Iniciar Sesion" autofocus = "on">
		</p>
		<p>
			<label>Contraseña</label>
			<input type="password" name="clave" placeholder = "Contraseña de Acesso al Sistema">
		</p>
		<p>
			<label>Idioma</label>
			<select name="idioma_seleccionado">
				<?php
					echo Funciones::getCombo('tb_idiomas','cod_language,language');
				?>
			</select>
		</p>
		
		<button>Ingresar</button>
		<input type="hidden" name="action" value="makeLogin">

	</form>	
</section>
