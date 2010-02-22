<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>

<div class="mapa"><strong>Canal Corporativo</strong> > Novedades</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Novedades</h1></td>
			<td width="5%" align="center"><?php echo link_to(image_tag('cerrar_sesion_over.jpg', array('title' => 'limpiar', 'alt' => 'limpiar', 'border' => '0')), 'noticias/limpiar'); ?></td>			
			<td width="5%" align="center"><?php $nombretabla = 'Noticia'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
		<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Noticia/s</span>
		<?php if(validate_action('alta')):?>
		<input type="button" onclick="javascript:location.href='<?php echo url_for('noticias/nueva') ?>';" style="float: right;" value="Crear Nueva Novedad" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="11%"><a href="<?php echo url_for('noticias/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a></th>
					<th width="11%"></th>
					<th width="57%"><a href="<?php echo url_for('noticias/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">T&iacute;tulo</a></th>
					<th width="20%" align="center"><a href="<?php echo url_for('noticias/index?sort=estado&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Publicado</a></th>
					<th width="4%"><a href="#"/></th>
					<th width="4%"><a href="#"/></th>
					<th width="4%"></th>
				</tr>
				<?php $i=0; foreach ($noticia_list as $noticia): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="middle" align="center">
						<?php
							echo date("d/m/Y", strtotime($noticia->getFecha()));
						?>
					</td>
					<td>
					<?php		
						if ($noticia->getImagen()) {
							echo image_tag('/uploads/noticias/images/'.$noticia->getImagen(), array('height' => 50, 'width' => 50, 'alt' => $noticia->getTitulo()));
						}
						else {	
							echo image_tag('noimage.jpg', array('height' => 50, 'width' => 50, 'alt' => $noticia->getTitulo()));
						}
				    ?>
					</td>
					<td valign="top" >
						<a href="<?php echo url_for('noticias/show?id=' . $noticia->getId()) ?>"><strong><?php echo $noticia->getTitulo() ?></strong></a>
					</td>
					<td valign="top" ><?php echo ($noticia->getEstado() == 'publicado')? image_tag('aceptada.png', array('border' => 0, 'title' => 'Publicado')): ''; ?></td>
					<td valign="top">
						<?php
							if ( validate_action('publicar') && $noticia->getEstado() != 'publicado') { 
								echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'noticias/publicar?id=' . $noticia->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas publicar la noticia ' . $noticia->getTitulo() . '?'));
							}	
						?>
					</td>
					<td valign="top">
					<?php if (validate_action('modificar')):?>
					<a href="<?php echo url_for('noticias/editar?id='.$noticia->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?></a>
					<?php endif;?>
					</td>
					<td valign="top">
					<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'noticias/delete?id='.$noticia->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la noticia ' . $noticia->getTitulo() . '?')) ?>
				    <?php  endif;  ?>
				    </td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Noticias/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('noticias/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Novedad" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php endif; ?>		
</div>
<div class="rightside">
	<div class="paneles">
		<h1>Buscar</h1>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('noticias/index') ?>">
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td><label>Por T&iacute;tulo:</label></td>
					<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:89%;" name="caja_busqueda" value="<?php echo $cajaBsq ?>" class="form_input"/></td>
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
				<tr>
				<tr>
					<td style="padding-top: 5px;"><label>Destacadas:</label></td>
					<td>
						<input type="checkbox" value="1" <?php if($sf_user->getAttribute('noticias_nowdestacada')){ echo 'checked';}?>  style="width:80px;" name="destacadas_busqueda" id="destacadas_busqueda"  />
					</td>
				</tr>
				<tr>
				  <?php
					$todose = '';
					$pendiente = '';
					$publicado = ''; 
					$intranet = '';
					$web = '';
					$todosa = '';
					if($sf_user->getAttribute('noticias_nowestado') == '') { $todose = 'selected'; }
					elseif($sf_user->getAttribute('noticias_nowestado') == 'pendiente') { $pendiente = 'selected';} 
					elseif ($sf_user->getAttribute('noticias_nowestado') == 'publicado'){ $publicado = 'selected';} 
					if($sf_user->getAttribute('noticias_nowambito') == '') { $todosa = 'selected'; }
					elseif($sf_user->getAttribute('noticias_nowambito') == 'intranet') { $intranet = 'selected';} 
					elseif ($sf_user->getAttribute('noticias_nowambito') == 'web'){ $web = 'selected';} 
					?>  
					<td style="padding-top: 5px;"><label>&Aacute;mbito:</label></td>
					<td style="padding-top: 5px;"><select name="ambito_busqueda" id="ambito_ambito">
																				<option value="" <?php echo $todosa ?> >todos</option>
																				<option value="intranet" <?php echo $intranet ?> >intranet</option>
																				<option value="web" <?php echo $web ?> >web</option>
																				</select>	
				  </td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Estado:</label></td>
					<td style="padding-top: 5px;"><select name="estado_busqueda" id="estado_busqueda">
																				<option value="" <?php echo $todose ?>>todos</option>
																				<option value="pendiente" <?php echo $pendiente ?>  >pendiente</option>
																				<option value="publicado" <?php echo $publicado ?> >publicado</option>
																				</select>	
				  </td>
				</tr>
				<tr>
					<td style="padding-top:5px;" >
						<span class="botonera"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></span>
					</td>
					<td>
							<?php if ($cajaBsq  || $desdeBsq || $hastaBsq || $destacadaBsq || $ambitoBsq || $estadoBsq): ?>
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