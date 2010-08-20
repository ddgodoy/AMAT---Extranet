<?php

	use_helper('TestPager');
	$parcialSortBy = 'aplicaciones_rol/index?type='.$sortType.'&page='.$paginaActual.'&orden=1&sort=';
	use_helper('Security','Object');
?>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Aplicaciones por Rol</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Aplicaciones por Rol</h1></td>
			<td width="5%" align="center"><?php $nombretabla = 'AplicacionRol'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>
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
		<?php if($pager->haveToPaginate()):?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>

		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Regla/s</span>
		<?php if(validate_action('alta')):?>
		<input type="button" onclick="javascript:location.href='<?php echo url_for('aplicaciones_rol/nuevo') ?>';" style="float: right;" value="Crear Nueva Regla" class="boton"/>
		<?php endif;?>
	</div>
	<?php if ($cantidadRegistros > 0) : ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
		<tbody>
			<tr>
				<th width="24%"><a href="<?php echo url_for($parcialSortBy.'r.nombre') ?>">Rol/Perfil</a></th>
				<th width="23%"><a href="<?php echo url_for($parcialSortBy.'a.nombre') ?>">Aplicaci&oacute;n</a></th>
				<th width="7%" style="text-align:center;"><a href="<?php echo url_for($parcialSortBy.'ar.accion_alta') ?>">Alta</a></th>
				<th width="7%" style="text-align:center;"><a href="<?php echo url_for($parcialSortBy.'ar.accion_baja') ?>">Baja</a></th>
				<th width="7%" style="text-align:center;"><a href="<?php echo url_for($parcialSortBy.'ar.accion_modificar') ?>">Modificar</a></th>
				<th width="7%" style="text-align:center;"><a href="<?php echo url_for($parcialSortBy.'ar.accion_listar') ?>">Listar</a></th>
				<th width="7%" style="text-align:center;"><a href="<?php echo url_for($parcialSortBy.'ar.accion_publicar') ?>">Publicar</a></th>
				<th width="4%"></th>
				<th width="4%"></th>
			</tr>
			<?php $i=0; foreach ($aplicacion_rol_list as $aplicacion_rol): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
			<tr class="<?php echo $odd ?>">
				<td><?php echo $aplicacion_rol->getRol() ?></td>
				<td><?php echo $aplicacion_rol->getAplicacion() ?></td>
				<td align="center"><?php echo ($aplicacion_rol->getAccionAlta())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion_rol->getAccionBaja())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion_rol->getAccionModificar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion_rol->getAccionListar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion_rol->getAccionPublicar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center">
				<?php if(validate_action('modificar')):?>
					<a href="<?php echo url_for('aplicaciones_rol/editar?id=' . $aplicacion_rol->getId()) ?>"><?php echo image_tag('edit.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a>
				<?php endif;?>	
				</td>
				<td align="center">
				<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'aplicaciones_rol/delete?id='.$aplicacion_rol->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar esta regla "' . $aplicacion_rol->getRol() . '"?')) ?>
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
			<input type="button" onclick="javascript:location.href='<?php echo url_for('aplicaciones_rol/nuevo') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Regla" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
	<?php endif; ?>
</div>
<!-- * -->
<div class="rightside" style="width:23%;">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('aplicaciones_rol/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
			       <tr>
					<td width="10%">
					Aplicaci&oacute;n:
					</td>
						<td width="90%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<td width="10%">
					Rol/Perfil:
					</td>
						<td width="90%">
							<?php echo select_tag('rol',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(RolTable::getAllRol()),$cajaRolBsq),array('style'=>'width:150px'));?>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
						<?php if ($cajaBsq || $cajaRolBsq): ?>
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