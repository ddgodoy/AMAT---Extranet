	<h1 class="especial">Bienvenido a la Extranet de Asociados Amat</h1>
	<div class="left_pan"><div class="paneles"><?php include_component('agenda', 'agenda') ?></div></div>
	<div class="right_pan"><div class="paneles"><?php //include_component('notificaciones', 'ultimos_avisos') ?></div></div>
	<div class="middle_pan"><div class="paneles"><?php  include_component('noticias', 'ultimas_noticias') ?></div></div>

	<div class="clear"></div>
	
	<div class="paneles">
		<h1>Accesos a las aplicaciones Externas</h1>
		<div class="enlaces">
			<?php foreach ($aplicacionesExternas as $valor): ?>
				<a href="<?php echo $valor->getUrl() ?>" target="_blank">
					<img src="<?php echo '/uploads/aplicaciones_externas/'.$valor->getImagen() ?>" title="<?php echo $valor->getNombre() ?>" border="0"/>
				</a>
			<?php endforeach; ?>

			<!--			
			<a href="#"><img src="/images/ban_sanresina.jpg" width="151" height="52" alt="Sam Resina" border="0"/></a>
			<a href="#"><img src="/images/ban_estadistica.jpg" width="151" height="52" alt="Estadísticas" border="0"/></a>
			<a href="#"><img src="/images/ban_webamat.jpg" width="151" height="52" alt="Web Amat" border="0"/></a>
			-->
			<div class="clear"></div>
		</div>
	</div>

	<div class="clear"></div>