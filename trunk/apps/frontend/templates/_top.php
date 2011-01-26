<div class="subhead">
	<div class="uno">
		<strong>Bienvenido</strong>
		<?php
			Agenda::getRepository()->setLabelHeaderUser($sf_user->getAttribute('userId'));
			echo $sf_user->getAttribute('nombre') . ' ' . $sf_user->getAttribute('apellido').', Organizaci&oacute;n: '.$sf_user->getAttribute('mutua');
		?>
	</div>
	<span class="dos">
		<a href="<?php echo url_for('inicio/index') ?>" class="a">INICIO</a>
		<a href="<?php echo url_for('mapasitio/index') ?>" class="d">MAPA DE WEB</a>
		<a href="<?php echo url_for('usuarios/perfil') ?>" class="b">MIS DATOS</a>
		<a href="<?php echo url_for('seguridad/logout') ?>" class="c" onclick="return confirm('Confirma cerrar la sesi&oacute;n?');">
			CERRAR SESION
		</a>
	</span>
</div>