<?php
	use_helper('TestPager');
	use_helper('Security');
?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('publicaciones/publicar') ?>';
		var rutaToDel = '<?php echo url_for('publicaciones/delete') ?>';
		var objectFrm = $('frmListDocOrganismos');

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
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa"><strong>Canal Corporativo</strong> > Web Amat  > Publicaciones</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Publicaciones</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Publicacion'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
				<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
				<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s <?php if ($cajaBsq) echo " con la palabra '".$cajaBsq."'" ?> </span> 
			<?php if (validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('publicaciones/nueva') ?>';" style="float: right;" value="Nueva publicaci&oacute;n" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="" id="frmListDocOrganismos">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<?php if (validate_action('publicar') || validate_action('baja')): ?>
					<th width="1%"></th>
	      		    <?php endif;?>
					<th width="5%" >
						<a href="<?php echo url_for('publicaciones/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="47%">
						<a href="<?php echo url_for('publicaciones/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($publicacion_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<?php if (validate_action('publicar') || validate_action('baja')): ?>
						<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<?php endif; ?>
					<td valign="center" >
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
						<a href="<?php echo url_for('publicaciones/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getTitulo() ?></strong>
						</a>
					</td>
					<td valign="center" align="center">
					<?php if (validate_action('modificar')):?> 
						<a href="<?php echo url_for('publicaciones/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>	
						</a>
					<?php endif; ?>		
					</td>
          <td valign="center" align="center">
          <?php
          	if (validate_action('baja')) {
          		echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'publicaciones/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?'));
          	}
          ?>
          </td>
				</tr>
				<?php endforeach; ?>
				<?php if (validate_action('publicar') || validate_action('baja')): ?>
			   <tr>
	          <td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
	          <td colspan="4">
							<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" />
	          </td>
				 </tr>
			   <?php endif; ?>
			</tbody>
		</table>
		</form>
		<?php else: ?>
			<?php if ($cajaBsq != '' || $desdeBsq || $hastaBsq || $ambitoBsq) : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else: ?>
				<div class="mensajeSistema comun">No hay registros cargados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
			<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
			<?php if (validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('publicaciones/nueva') ?>';" style="float: right;" value="Nueva publicaci&oacute;n" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('publicaciones/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="20%">T&iacute;tulo</td>
						<td width="80%"><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/></td>
					</tr>
					<tr>
					<td><label>Fecha Desde:</label></td>
					<td valign="middle">
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
				<?php
					if (Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles)):
						$todosa   = '';
						$intranet = '';
						$web      = '';
						$ssUserFl = $sf_user->getAttribute('publicaciones_nowambito');
	
						if ($ssUserFl == 'todos') {
							$todosa = 'selected';
						} elseif ($ssUserFl == 'intranet') {
							$intranet = 'selected';
						} elseif ($ssUserFl == 'web') {
							$web = 'selected';
						}
				?>
				<tr>
					<td style="padding-top: 5px;"><label>&Aacute;mbito:</label></td>
					<td style="padding-top: 5px;">
						<select name="ambito_busqueda" id="ambito_ambito">
							<option value="" >--seleccionar--</option>
							<option value="todos" <?php echo $todosa ?> >Extranet y Web</option>
							<option value="web" <?php echo $web ?> >web</option>
							<option value="intranet" <?php echo $intranet ?> >Extranet</option>
						</select>
				  </td>
				</tr>
				<?php endif; ?>
				<tr>
						<td style="padding-top:5px;"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></td>
						<td>
						<?php if ($cajaBsq != '' || $desdeBsq || $hastaBsq): ?>
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