<?php

	use_helper('TestPager');
	$parcialSortBy = 'aplicaciones_externas_usuario/index?type='.$sortType.'&page='.$paginaActual.'&sort=';
	use_helper('Security');
?>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Aplicaciones Externas de Usuario</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="95%"><h1>Aplicaciones Externas del Usuario</h1></td>
			<td width="5%" align="right">
				<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
			</td>
		</tr>
	</tbody>
</table>

<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

<!-- * -->
<div class="leftside" style="width:75%;">
	<div class="lineaListados">
		<?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>

		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Regla/s</span>
		<?php if(validate_action('alta')):?>
		<input type="button" onclick="javascript:location.href='<?php echo url_for('aplicaciones_externas_usuario/nuevo') ?>';" style="float: right;" value="Crear Nueva Regla" class="boton"/>
		<?php endif;?>
	</div>
	<?php if ($cantidadRegistros > 0) : ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
		<tbody>
			<tr>
				<th width="10%"><a href="<?php echo url_for($parcialSortBy.'ae.nombre') ?>">Aplicación</a></th>
				<th width="24%"><a href="<?php echo url_for($parcialSortBy.'aeu.login') ?>">Login</a></th>
				<th width="4%"></th>
				<th width="4%"></th>
			</tr>
			<?php $i=0; foreach ($aplicacion_externa_usuario_list as $value): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
			<tr class="<?php echo $odd ?>">
				<td><strong><a href="<?php echo url_for('aplicaciones_externas_usuario/editar?uid=' . $value->getUsuarioId(). '&aeid=' . $value->getAplicacionExternaId()) ?>"><?php echo $value->getAplicacionExterna()->getNombre() ?></a></strong></td>
				<td><?php echo $value->getLogin() ?></td>
				<td align="center">
				<?php if(validate_action('modificar')):?>
					<a href="<?php echo url_for('aplicaciones_externas_usuario/editar?uid=' . $value->getUsuarioId(). '&aeid=' . $value->getAplicacionExternaId()) ?>"><?php echo image_tag('edit.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a>
				<?php endif;?>	
				</td>
				<td align="center">
				<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'aplicaciones_externas_usuario/delete?id='.$value->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar esta regla "' . $value->getRol() . '"?')) ?>
				<?php endif;?>	
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>	
	<?php else : ?>
		<?php if ($cajaBsq != '') : ?>
			<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
		<?php else : ?>
			<div class="mensajeSistema comun">No hay Reglas registradas</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Regla/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('aplicaciones_externas_usuario/nuevo') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Regla" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
	<?php endif; ?>
</div>
<!-- * -->
<div class="rightside" style="width:23%;">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('aplicaciones_externas_usuario/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
			<tr>
					<td>
					Aplicaci&oacute;n:
					</td>
						<td>
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ($cajaBsq): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif;  ?>
						</td>
					</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>
<!-- * -->
<div class="clear"></div>