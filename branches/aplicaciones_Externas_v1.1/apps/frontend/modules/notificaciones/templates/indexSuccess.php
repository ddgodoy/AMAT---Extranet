<?php use_helper('Security') ?>
<?php use_helper('Object') ?>
<?php use_helper('TestPager'); $parcialSortBy = 'notificaciones/index?type='.$sortType.'&page='.$paginaActual.'&orden=1&sort='; ?>
<div class="mapa"><strong>Canal Corporativo</strong> > Avisos</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Avisos</h1></td>	
			 <td width="5%" align="right">
				<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
			</td>
		</tr>
	</tbody>
</table>
<div class="leftside">
		<?php if ($cantidadRegistros > 0) : ?>
		<?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="10%"><a href="<?php echo url_for($parcialSortBy.'n.created_at')?>">Fecha</a></th>
					<th width="20%"><a href="<?php echo url_for($parcialSortBy.'cn.titulo')?>">Contenido</a></th>
					<th width="60%"><a href="<?php echo url_for($parcialSortBy.'n.nombre')?>">Título</a></th>
					<th width="5%"><a href="<?php echo url_for($parcialSortBy.'n.visto')?>">Visado</a></th>
					<th width="5%"></th>
				</tr>
				<?php $i=0; foreach ($ultimos_avisos as $aviso): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td align="left"><?php echo date("d/m/Y", strtotime($aviso->getCreatedAt())) ?></td>
					<td><?php echo $aviso->getContenidoNotificacion()->getTitulo() ?></td>
      		        <td><a href="<?php echo url_for($aviso->getUrl()) ?>"><?php echo $aviso->getNombre() /*$aviso->getContenidoNotificacion()->getTitulo()*/ ?></a></td>
      		        <td align="center">
					<?php if($aviso->getVisto() == 1){echo image_tag('aceptada.png', array('title' => 'Visado', 'alt' => 'Visado', 'border' => '0'));}else{echo link_to(image_tag('confirma.png', array('title' => 'Visar', 'alt' => 'Visar',  'border' => '0')), 'notificaciones/visar?id='.$aviso->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas realizar esta acci&oacute;n?'));} ?>
				    </td>
		      		<td valign="top">
					<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'notificaciones/delete?id='.$aviso->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar el aviso: ' . $aviso->getContenidoNotificacion()->getTitulo() . '?')) ?>
				    <?php  endif;  ?>
				    </td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>
		<?php else : ?>
				<div class="mensajeSistema comun">No hay Avisos registrados</div>
		<?php endif; ?>
</div>
<div class="rightside">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('notificaciones/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td><label>Por Contenido:</label></td>
					<td><?php echo select_tag('categoria',
						options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(ContenidoNotificacionTable::getOneByAccionAndEntidad()),$sf_user->getAttribute('notificaciones_nowcaja')),
						array('style'=>'width:200px;','class'=>'form_input')); ?>
				</tr>
				<tr>
					<td style="padding-top:5px;" >
						<span class="botonera"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></span>
					</td>
					<td>
							<?php if ($cajaBsq ): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif; ?>								
						
						</td>	
				</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>
<div class="clear"></div>