<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Perfiles</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Perfiles</h1></td>
			<td width="5%" align="center"><?php $nombretabla = 'Rol'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_csv.jpg', array('title' => 'Exportar csv', 'alt' => 'Exportar csv', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.csv'); ?></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('export_xml.jpg', array('title' => 'Exportar xml', 'alt' => 'Exportar xml', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xml'); ?></td>			
			<td width="5%" align="right">
				<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
			</td>
		</tr>
	</tbody>
</table>
<div class="leftside">
	<div class="lineaListados">
        <?php if($pager->haveToPaginate()): ?>
		<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		<?php endif; ?>
		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Perfil/es</span>
		<?php if(validate_action('alta')):?>
		<input type="button" onclick="javascript:location.href='<?php echo url_for('perfiles/nueva') ?>';" style="float: right;" value="Crear Nuevo Perfil" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
	<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="11%"><a href="<?php echo url_for('perfiles/index?sort=created_at&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a></th>
					<th width="57%"><a href="<?php echo url_for('perfiles/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nombre</a></th>
					<th width="20%"><a href="<?php echo url_for('perfiles/index?sort=codigo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Codigo</a></th>
					<th width="20%"><a href="<?php echo url_for('perfiles/index?sort=detalle&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Detalles</a></th>
					<th width="4%"><a href="#"/></th>
					<th width="4%"><a href="#"/></th>
					<th width="4%"><a href="#"/></th>
				</tr>
				<?php $i=0;  foreach ($rol_list as $rol): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="middle" align="center">
						<?php
							echo date("d/m/Y", strtotime($rol->getCreatedAt()));
						?>
					</td>
					 <td><a href="<?php echo url_for('perfiles/editar?id='.$rol->getId()) ?>"><?php echo $rol->getNombre() ?></a></td>
      				<td><?php echo $rol->getCodigo() ?></td>
      				<td><?php echo $rol->getDetalle() ?></td>					
      				<td valign="top">
					<?php if (validate_action('modificar')):?>
					<a href="<?php echo url_for('perfiles/editar?id='.$rol->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?></a>
					<?php endif;?>
					</td>
					<td valign="top">
					<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'perfiles/delete?id='.$rol->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la noticia ' . $rol->getNombre() . '?')) ?>
				    <?php  endif;  ?>
				    </td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if (!$cajaBsq || !$desdeBsq ) : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Noticias registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Perfil/es</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('perfiles/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nuevo Peril" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php endif; ?>		
</div>
<div class="rightside">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('perfiles/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td><label>Por Perfil:</label></td>
					<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:89%;" name="caja_busqueda" value="<?php echo $cajaBsq ?>" class="form_input"/></td>
				</tr>
				<tr>
					<td><label>Fecha:</label></td>
					<td valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $desdeBsq ?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top:5px;" >
						<span class="botonera"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></span>
					</td>
				<td>
				<?php if ($cajaBsq  || $desdeBsq ): ?>
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
