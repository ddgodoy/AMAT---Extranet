<?php
	use_helper('TestPager');
	use_helper('Javascript');
	
	$nombreAplicacion = $aplicacion->getNombre();
?>
<div class="mapa">
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('aplicaciones/index') ?>">Aplicaciones</a> &gt; 
	Usuarios de la aplicaci&oacute;n
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Usuarios en la aplicaci&oacute;n &quot;<?php echo $nombreAplicacion ?>&quot;</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>
<div class="leftside">
	<div class="lineaListados">
		<?php if ($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, '', '', "id=$id_aplicacion", 'usuarios') ?></div>
		<?php endif; ?>
		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Usuario/s</span>
	</div>
	<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="25%">Apellido</th>
					<th width="25%">Nombre</th>
					<th width="25%">Perfil</th>
					<th width="5%">Alta</th>
					<th width="5%">Baja</th>
					<th width="5%">Modificar</th>
					<th width="5%">Listar</th>
					<th width="5%">Publicar</th>
				</tr>
				<?php
					$i = 0;
					foreach ($usuarios_list as $valor):
						$odd = fmod(++$i, 2) ? 'blanco' : 'gris';
					
						$userDetails = AplicacionRol::getArraPerfilAplicacionAccionBYusuario($valor->getId());

						foreach ($userDetails as $aplicacion_rol):
							
							foreach ($aplicacion_rol['apliacio'] as $aplicacion):

								if ($aplicacion->Aplicacion->getNombre() == $nombreAplicacion):
				?>
						<tr class="<?php echo $odd ?>">
							<td valign="top"><?php echo $valor->getApellido() ?></td>
							<td valign="top"><?php echo $valor->getNombre() ?></td>
							<td valign="top"><?php echo $aplicacion_rol['perfil'] ?></td>
							<td align="center"><?php echo $aplicacion->getAccionAlta() ? image_tag('aceptada.png') : image_tag('rechazada.png') ?></td>
							<td align="center"><?php echo $aplicacion->getAccionBaja() ? image_tag('aceptada.png') : image_tag('rechazada.png') ?></td>
							<td align="center"><?php echo $aplicacion->getAccionModificar()?image_tag('aceptada.png') : image_tag('rechazada.png') ?></td>
							<td align="center"><?php echo $aplicacion->getAccionListar() ? image_tag('aceptada.png') : image_tag('rechazada.png') ?></td>
							<td align="center"><?php echo $aplicacion->getAccionPublicar() ? image_tag('aceptada.png') : image_tag('rechazada.png') ?></td>
						</tr>
						<?php
							endif;
							endforeach;
						?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="lineaListados">
			<?php if ($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, '', '', "id=$id_aplicacion", 'usuarios') ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Usuario/s</span>
		</div>

	<?php else: ?>
		<div class="mensajeSistema comun">No hay usuarios relacionados con la aplicaci&oacute;n</div>
	<?php endif; ?>
</div>
<br clear="all" />