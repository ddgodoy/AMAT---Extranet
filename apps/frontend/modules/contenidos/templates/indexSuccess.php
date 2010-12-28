<?php use_helper('TestPager','Security','Text','Object') ?>

<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>

<div class="mapa"><strong>Administraci&oacute;n</strong> &gt; Contenidos</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Contenidos</h1></td>
			<td width="5%" align="center"><?php $nombretabla = 'Aplicacion'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>			
			<td width="5%" align="right">
				<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
			</td>
		</tr>
	</tbody>
</table>
<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>
<div class="leftside">
	<div class="lineaListados">
		<?php if ($pager->haveToPaginate()): ?><div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div><?php endif; ?>
		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Contenido/s</span>
		<?php if (validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('contenidos/nueva') ?>';" style="float: right;" value="Crear nuevo contenido" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
	<?php if ($cantidadRegistros > 0): ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
		<tbody>
			<tr>
				<th width="10%" style="text-align:center;">
					<a href="<?php echo url_for('contenidos/index?sort=created_at&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
				</th>
				<th width="35%">
					<a href="<?php echo url_for('contenidos/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nombre</a>
				</th>
				<th width="38%">
					<a href="<?php echo url_for('contenidos/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
				</th>
				<?php if ($viewE): ?><th width="7%">Estado</th><?php endif; ?>
				<th width="5%">&nbsp;</th>
				<th width="5%">&nbsp;</th>
			</tr>
			<?php $i = 0; foreach ($aplicaciones_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris'; ?>
			<tr class="<?php echo $odd ?>">
				<td valign="top" align="center"><?php echo date("d/m/Y", strtotime($valor->getCreatedAt())) ?></td>
				<td valign="top">
					<a href="<?php echo url_for('contenidos/show?id=' . $valor->getId()) ?>"><strong><?php echo $valor->getNombre() ?></strong></a>
				</td>
				<td valign="top"><?php echo $valor->getTitulo() ?></td>
				<?php if ($viewE): ?><td valign="top" align="center"><?php echo ucfirst($valor->getEstado()) ?></td><?php endif; ?>
				<td valign="top" align="center">
				<?php if (validate_action('modificar')): ?>
					<a href="<?php echo url_for('contenidos/editar?id='.$valor->getId().'&page='.$paginaActual) ?>">
						<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
					</a>
				<?php endif; ?>	
				</td>
				<td valign="top" align="center">
				<?php
					if (validate_action('baja')) {
						echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'contenidos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?'));
					}
				?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php else: ?>
		<?php if ($cajaBsq != '') : ?>
			<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
		<?php else: ?>
			<div class="mensajeSistema comun">No hay Aplicaciones registradas</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if ($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Contenido/s</span>
			<?php if (validate_action('alta')):?>
				<input type="button" onclick="javascript:location.href='<?php echo url_for('contenidos/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear nuevo contenido" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre/T&iacute;tulo</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('contenidos/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="30%">Nombre/T&iacute;tulo</td>
						<td width="70%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></td>
						<td><?php if ($cajaBsq): ?><span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span><?php endif; ?></td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
<!-- * -->
<div class="clear"></div>