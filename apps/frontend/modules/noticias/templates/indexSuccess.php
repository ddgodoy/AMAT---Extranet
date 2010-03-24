<?php use_helper('TestPager') ?>
<?php use_helper('Security');
use_helper('Text');?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('noticias/publicar') ?>';
		var rutaToDel = '<?php echo url_for('noticias/delete') ?>';
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

<div class="mapa"><strong>Canal Corporativo</strong> > Noticia</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="70%"><h1>Noticia</h1></td>
			<!--<td width="5%" align="center"><?php // echo link_to(image_tag('cerrar_sesion_over.jpg', array('title' => 'limpiar', 'alt' => 'limpiar', 'border' => '0')), 'noticias/limpiar'); ?></td>			-->
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
		<input type="button" onclick="javascript:location.href='<?php echo url_for('noticias/nueva') ?>';" style="float: right;" value="Crear Nueva Noticia" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<?php if( !validate_action('publicar') && !validate_action('modificar') && !validate_action('baja') ):?><div style="border-bottom:5px solid #CCC; margin:10px 0px;"></div><?php endif;?>
		<form method="post" enctype="multipart/form-data" action="" id="frmListDocOrganismos">
		<table width="100%" cellspacing="0" cellpadding="0" class="listados" <?php if( !validate_action('publicar') && !validate_action('modificar') && !validate_action('baja') ):?>style="border:none;"<?php endif;?>>
			<tbody>
			<?php if(validate_action('publicar') || validate_action('modificar') || validate_action('baja') ):?>
				<tr>
					<?php if (validate_action('publicar') || validate_action('baja')): ?>
					<th width="3%"></th>
	      		    <?php endif;?>
					<th width="11%">
						<a href="<?php echo url_for('noticias/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>" style="padding-left:30px;">
							Fecha
						</a>
					</th>
					<th width="60%"><a href="<?php echo url_for('noticias/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">T&iacute;tulo</a></th>
					<th width="3%"><a href="#"/></th>
					<th width="3%"><a href="#"/></th>
					<th width="3%"></th>
				</tr>
			<?php endif;?>	
				<?php $i=0; foreach ($noticia_list as $noticia): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<?php if(validate_action('publicar') || validate_action('modificar') || validate_action('baja') ):?>
				<?php if($noticia->getEstado() == 'guardado'):?>
				<?php if($noticia->getUserIdCreador() == $sf_user->getAttribute('userId')):?>
				<?php include_partial('ListadoNoticias', array('noticia'=>$noticia, 'odd'=>$odd));?>
				<?php endif; ?>
				<?php else: ?>
				<?php include_partial('ListadoNoticias', array('noticia'=>$noticia, 'odd'=>$odd));?>
				<?php endif; ?>
				<?php else: ?>
				<?php if($noticia->getEstado() == 'guardado' && $noticia->getEstado() == 'pendiente'):?>
				<?php if($noticia->getUserIdCreador() == $sf_user->getAttribute('userId')):?>
				<?php include_partial('ListadoNoticiaUsuarios', array('noticia'=>$noticia, 'odd'=>$odd));?>
				<?php endif; ?>
				<?php else: ?>
				<?php include_partial('ListadoNoticiaUsuarios', array('noticia'=>$noticia, 'odd'=>$odd));?>
				<?php endif; ?>
   		        <?php endif;?>
			    <?php endforeach; ?>
			   <?php if(validate_action('publicar') || validate_action('baja')):?>
			   <tr>
					<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
					<td colspan="5">
						<!--<input type="submit" class="boton" value="Publicar seleccionados" name="btn_publish_selected" onclick="return setActionFormList('publicar');"/>-->
						<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" />
					</td>
				</tr>
			   <?php endif; ?>
			</tbody>
		</table>
		</form>
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
			<input type="button" onclick="javascript:location.href='<?php echo url_for('noticias/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Noticia" name="newNews" class="boton"/>
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
					<td style="padding-top: 5px;"><label>Destacadas:</label></td>
					<td style="padding-top: 5px;" align="left">
						<input type="checkbox" value="1" <?php if($sf_user->getAttribute('noticias_nowdestacada')){ echo 'checked';}?> name="destacadas_busqueda" id="destacadas_busqueda"  />
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Novedad:</label></td>
					<td style="padding-top: 5px;" align="left">
						<input type="checkbox" value="1" <?php if($novedadBsq){ echo 'checked';}?> name="novedad_busqueda" id="novedad_busqueda"  />
					</td>
				</tr>
				<?php
					$todose = '';
					$guardao = '';
					$pendiente = '';
					$publicado = ''; 
					$intranet = '';
					$web = '';
					$todosa = '';
					if($sf_user->getAttribute('noticias_nowestado') == '') { $todose = 'selected'; }
					elseif($sf_user->getAttribute('noticias_nowestado') == 'guardado') { $guardao = 'selected';} 
					elseif($sf_user->getAttribute('noticias_nowestado') == 'pendiente') { $pendiente = 'selected';} 
					elseif ($sf_user->getAttribute('noticias_nowestado') == 'publicado'){ $publicado = 'selected';} 
					if($sf_user->getAttribute('noticias_nowambito') == 'todos') { $todosa = 'selected'; }
					elseif($sf_user->getAttribute('noticias_nowambito') == 'intranet') { $intranet = 'selected';} 
					elseif ($sf_user->getAttribute('noticias_nowambito') == 'web'){ $web = 'selected';} 
					?>  

				<?php if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles)): ?>
				<tr>
				    <td style="padding-top: 5px;"><label>&Aacute;mbito:</label></td>
					<td style="padding-top: 5px;"><select name="ambito_busqueda" id="ambito_ambito">
																				<option value="" >--seleccionar--</option>
																				<option value="todos" <?php echo $todosa ?> >Intranet y Web</option>
																				<option value="web" <?php echo $web ?> >web</option>
																				<option value="intranet" <?php echo $intranet ?> >intranet</option>
																				</select>	
				  </td>
				</tr>
				<?php endif; ?>
				<?php if(validate_action('publicar') || validate_action('modificar') || validate_action('baja')):?>
				<tr>
					<td style="padding-top: 5px;"><label>Estado:</label></td>
					<td style="padding-top: 5px;"><select name="estado_busqueda" id="estado_busqueda">
																				<option value="" >--seleccionar--</option>
																				<option value="guardado" <?php echo $guardao ?>>guardado</option>
																				<option value="pendiente" <?php echo $pendiente ?>>pendiente</option>
																				<option value="publicado" <?php echo $publicado ?>>publicado</option>
																				</select>	
				  </td>
				</tr>
				<?php endif; ?>
				<tr>
					<td style="padding-top:5px;" >
						<span class="botonera"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></span>
					</td>
					<td>
							<?php if ($cajaBsq  || $desdeBsq || $hastaBsq || $destacadaBsq || $ambitoBsq || $estadoBsq || $novedadBsq): ?>
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