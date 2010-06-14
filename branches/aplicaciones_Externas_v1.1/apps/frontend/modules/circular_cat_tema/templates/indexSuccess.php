<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Circulares - Categor&iacute;as de Tema</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Categor&iacute;as de Tema</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'CircularCatTema'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Categor&iacute;a/s de Tema</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('circular_cat_tema/nueva') ?>';" style="float: right;" value="Crear Nueva Categor&iacute;a" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="15%" style="text-align:center;">
						<a href="<?php echo url_for('circular_cat_tema/index?sort=created_at&type='.$sortType.'&page='.$paginaActual) ?>">Alta</a>
					</th>
					<th width="70%">
						<a href="<?php echo url_for('circular_cat_tema/index?sort=nombre&type='.$sortType.'&page='.$paginaActual) ?>">Categor&iacute;a</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($circular_cat_tema_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="top" align="center">
						<?php echo date("d/m/Y [H:i]", strtotime($valor->getCreatedAt())) ?>
					</td>
					<td valign="top">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('circular_cat_tema/editar?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?> 	
					</td>
					<td valign="top" align="center">
						<a href="<?php echo url_for('circular_sub_tema/index?cat='.$valor->getId()) ?>">
							<?php echo image_tag('listado.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Subcategor&iacute;as de '.$valor->getNombre())) ?>
						</a>
					</td>
					<td valign="top" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('circular_cat_tema/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('edit.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
						</a>
					<?php endif;?>	
					</td>
          <td valign="top" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'circular_cat_tema/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
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
				<div class="mensajeSistema comun">No hay Categor&iacute;as de Tema registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Categor&iacute;a/s de Tema</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('circular_cat_tema/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Categor&iacute;a" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por nombre de Categor&iacute;a</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('circular_cat_tema/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td width="30%"> 
					Categor&iacute;a
					</td>
						<td width="70%">
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