<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>

<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('eventos/publicar') ?>';
		var rutaToDel = '<?php echo url_for('eventos/delete') ?>';
		var objectFrm = $('frmListEventos');

		if (accion == 'publicar') {
			objectFrm.action = rutaToPub;
			parcialMensaje = 'publicación';
		} else {
			objectFrm.action = rutaToDel;
			parcialMensaje = 'eliminación';
		}
		if (confirm('Confirma la '+ parcialMensaje +' de los registros seleccionados?')) {
			return true;
		}
		return false;
	}
</script>

<div class="mapa"><strong>Canal Corporativo</strong> &gt Eventos</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
			<tr>
			<td width="70%"><h1>Eventos</h1></td>
			<td width="5%" align="center"><?php $nombretabla = 'Evento'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>
			<td width="5%" align="right">
				<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
			</td>
			
		</tr>
		</tr>
	</tbody>
</table>

<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

<!-- * -->
<div class="leftside">
	<div class="lineaListados">
		<?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>
	
		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Evento/s</span>
		<?php if(validate_action('alta')):?> 
		<input type="button" onclick="javascript:location.href='<?php echo url_for('eventos/nuevo') ?>';" style="float: right;" value="Crear Nuevo Evento" class="boton"/>
		<?php endif;?>
	</div>
	
	<?php if ($cantidadRegistros > 0) : ?>
<form method="post" enctype="multipart/form-data" action="" id="frmListEventos">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
	<tbody>
	<tr>
	   <?php if (validate_action('publicar') || validate_action('baja')): ?>
		<th width="3%"></th>
	   <?php endif;?>
		<th width="8%"><a href="<?php echo url_for('eventos/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a></th>
		<th width="22%"><a href="<?php echo url_for('eventos/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Título</a></th>
		<th width="21%"><a href="<?php echo url_for('eventos/index?sort=organizador&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Organizador</a></th>
		<th width="13%"><a href="<?php echo url_for('eventos/index?sort=estado&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Estado</a></th>
		<th width="3%"></th>
		<th width="3%"></th>
		<th width="3%"></th>
	</tr>
	<?php $i=0; foreach ($evento_list as $evento): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
	<tr class="<?php echo $odd ?>">
	<?php if (validate_action('publicar') && $evento->getEstado() == 'pendiente' || validate_action('baja')): ?>
		<td><input type="checkbox" name="id[]" value="<?php echo $evento->getId() ?>" /></td>
	<?php endif;?>	
		<td><?php echo date("d/m/Y", strtotime($evento->getFecha())) ?></td>
		
			<td><a href="<?php echo url_for('eventos/show?id=' . $evento->getId()) ?>"><strong><?php echo $evento->getTitulo() ?></strong></a></td>
			<td><?php echo $evento->getOrganizador() ?></td>
		<td><?php echo ucwords($evento->getEstado()) ?></td>
		<?php if (validate_action('publicar') && $evento->getEstado() == 'pendiente'): ?>
			<td>
				<?php echo link_to(image_tag('publicar.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')), 'eventos/publicar?id='.$evento->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas publicar este evento?')) ?>
			</td>
		<?php elseif ($evento->getEstado() == 'guardado'): ?>
			<td>
				<a href="#" onclick="alert('Para publicar este evento es necesario que su estado esté en Pendiente')"><?php echo image_tag('publicar.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')) ?></a>
			</td>
		<?php else: ?>
			<td>
				<a href="#" onclick="alert('El evento ya ha sido publicado anteriormente')"><?php echo image_tag('aceptada.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')) ?></a>
			</td>
		<?php endif; ?>
			<td>
			<?php if(validate_action('modificar')):?> 
				<a href="<?php echo url_for('eventos/editar?id=' . $evento->getId()) ?>"><?php echo image_tag('show.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a>
			<?php endif; ?>	
			</td>
		 <td>
		<?php if(validate_action('baja')):?>
			<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'border' => '0')), 'eventos/delete?id='.$evento->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar el evento "' . $evento->getTitulo() . '"?')) ?>
		<?php endif; ?>	
		</td>
	</tr>
	<?php endforeach; ?>
	<?php if (validate_action('publicar') && $evento->getEstado() == 'pendiente' || validate_action('baja')): ?>
	<tr>
		<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
		<td colspan="5">
			<input type="submit" class="boton" value="Publicar seleccionados" name="btn_publish_selected" onclick="return setActionFormList('publicar');"/>
			<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" style="margin-left:5px;"/>
		</td>
	</tr>
	<?php endif?>
	</tbody>
</table>
</form>
<?php else : ?>
	<?php if ($cajaBsq != '') : ?>
		<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
	<?php else : ?>
		<div class="mensajeSistema comun">No hay Eventos registrados</div>
	<?php endif; ?>
<?php endif; ?>

<?php if ($cantidadRegistros > 0) : ?>
<div class="lineaListados">
	<?php if($pager->haveToPaginate()): ?>
		<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	<?php endif; ?>

	<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Evento/s</span>
	<?php if(validate_action('alta')):?>
	<input type="button" onclick="javascript:location.href='<?php echo url_for('eventos/nuevo') ?>';" style="float:right;margin-top:10px;" value="Crear Nuevo Evento" name="newNews" class="boton"/>
	<?php endif;?>
</div>
<?php endif; ?>
</div>
<!-- * -->
<div class="rightside">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('eventos/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td><label>Por T&iacute;tulo:</label></td>
					<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:89%;" name="caja_busqueda" value="<?php echo $cajaBsq ?>" class="form_input"/></td>
				</tr>
				<tr>
					<td width="29%"><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $desdeBsq ?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
					<td style="padding-top: 5px;">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $hastaBsq ?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Ambito</label></td>
					<td style="padding-top: 5px;">
					<?php echo select_tag('ambito',options_for_select(array('0'=>'--seleccionar--','intranet' => 'intranet', 'web' => 'web', 'ambos' => 'ambos'),$ambitoBQ),array('class'=>"form_input"))?>	
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Estado</label></td>
					<td style="padding-top: 5px;">
					<?php echo select_tag('estado',options_for_select( array('0'=>'--seleccionar--','guardado' => 'guardado', 'pendiente' => 'pendiente', 'publicado' => 'publicado'),$estadoBq),array('class'=>"form_input"))?>	
				</tr>
				<tr>
				<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>	
						</td>
						<td>
							<?php if ($cajaBsq  || $desdeBsq || $hastaBsq || $ambitoBQ || $estadoBq ): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif; ?>								
						
						</td>	
				</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>
<!-- * -->
<div class="clear"></div>