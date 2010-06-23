	<h1 class="especial">Bienvenido a la Extranet Sectorial Amat</h1>
	<div class="left_pan"><div class="paneles"><?php include_component('agenda', 'agenda') ?></div></div>
	<div class="right_pan"><div class="paneles"><?php include_component('notificaciones', 'ultimos_avisos') ?></div></div>
	<div class="middle_pan"><div class="paneles"><?php  include_component('noticias', 'ultimas_noticias') ?></div></div>
        

	<div class="clear"></div>

        <?php if(count($aplicacionesExternas) >= 1): ?>
	<div class="paneles">
		<h1>Accesos a las aplicaciones Externas</h1>
		<div class="enlaces">
			<?php foreach ($aplicacionesExternas as $valor): ?>
				<a <?php if($valor->getAplicacionExterna()->getRequiere()!=1):?> href="<?php echo $valor->getAplicacionExterna()->getUrl() ?>" target="_blank"<?php else: ?> style=" cursor: pointer;" onclick="Confirmar_acceso('<?php echo $valor->getAplicacionExterna()->getUrl(); ?>','<?php echo $valor->getLogin(); ?>','<?php echo $valor->getPass(); ?>')"<?php endif; ?>>
			          <img align="middle" src="<?php echo '/uploads/aplicaciones_externas/'.$valor->getAplicacionExterna()->getImagen() ?>" title="<?php echo $valor->getAplicacionExterna()->getNombre() ?>" border="0"/>
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
        <?php endif;?>

	<div class="clear"></div>