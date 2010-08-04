<?php
	use_helper('TestPager');
	use_helper('Security');
	use_helper('Object');
	use_helper('Javascript');

	if ($sf_user->getAttribute('archivos_d_g_nowgrupo')) {
		$arrayDocumentacion = DocumentacionGrupoTable::doSelectByGrupoTrabajo($sf_user->getAttribute('archivos_d_g_nowgrupo'),'',$sf_user->getAttribute('userId'));
	} else {
		$arrayDocumentacion = DocumentacionGrupoTable::getAlldocumentos($sf_user->getAttribute('userId'));
	}
?>
<?php if($grupoBsq ):
$redireccionGrupo = 'archivo_d_g[documentacion_grupo_id]='.$documentacionBsq.'&grupo_trabajo_id='.$grupoBsq;
else :
$redireccionGrupo = '';
endif; ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>

<div class="mapa">
	<strong>Grupos de Trabajo</strong>
	<?php if ($documentacionBsq !='' && !empty($documentacion)): ?> > Documentaci&oacute;n: <?php echo $documentacion->getNombre(); endif;?> > Archivos
</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Archivos de <?php if ($documentacionBsq !='' && !empty($documentacion)): ?>Documentaci&oacute;n: <?php echo $documentacion->getNombre(); else: ?> Grupos de Trabajo <?php endif;?></h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'ArchivoDG ag'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
        <?php  include_partial('miembros_grupos_trabajos/MenuGrupo',array('Grupo' => $Grupo, 'modulo'=>$modulo))?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $redireccionGrupo) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s <?php if ($cajaBsq) echo " con la palabra '".$cajaBsq."'" ?> </span> 
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('archivo_d_grupo/index?sort=ag.fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Fecha</a>
					</th>
					<th width="35%">
						<a href="<?php echo url_for('archivo_d_grupo/index?sort=ag.nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Titulo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('archivo_d_grupo/index?sort=ag.grupo_trabajo_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Grupo de Trabajo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('archivo_d_grupo/index?sort=ag.owner_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Creado por</a>
					</th>
				</tr>
				<?php $i=0; foreach ($archivo_dg_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
						<a href="<?php echo url_for('archivo_d_grupo/show?id=' . $valor->getId().'&'.$redireccionGrupo) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					</td>
					<td valign="center" align="left">
					    <?php if ($valor->getGrupoTrabajoId()):?> 
					    <?php $Grupo = GrupoTrabajo::getRepository()->findOneById($valor->getGrupoTrabajoId())?>
						<?php echo $Grupo->getNombre() ?>
						<?php endif;?>
					</td>
					<td valign="center" align="left">
						<?php if($valor->getOwnerId()): ?>
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getOwnerId()) ?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
						<?php endif; ?>
					</td>
                                        </tr>
                                        <?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay registros cargados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $redireccionGrupo) ?></div>
			<?php endif; ?>
			
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
		</div>
		<?php endif; ?>
		<?php if($documentacionBsq && validate_action('listar','documenatcion_grupos_trabajo') && $grupoBsq): ?>
                   <?php $redireccion = $documentacionBsq?'?grupo='.$grupoBsq: ''; ?>
		  <input type="button" onclick="javascript:location.href='<?php echo url_for('documenatcion_grupos_trabajo/index'.$redireccion) ?>';"  value="Volver a la Documentacion" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="get" enctype="multipart/form-data" action="<?php echo url_for('archivo_d_grupo/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td>Texto</td>
						<td>
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<td width="29%"><label>Grupo de trabajo:</label></td>
						<td>
						<?php 
							echo select_tag('grupo_trabajo_id',
                                                        options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(GrupoTrabajoTable::getAllGrupoTrabajo()), $sf_user->getAttribute('archivos_d_g_nowgrupo')),
                                                        array('style'=>'width:200px;','class'=>'form_input')
                                                 );echo observe_field('grupo_trabajo_id', array('update'=>'content_documentacion','url'=>'documentacion_grupos/listByGrupoTrabajo','with'=>"'id_grupo_trabajo='+value"));
			                         ?>
						</td>
					</tr>
						<tr>
					<td width="29%"><label>Documentaci&oacute;n:</label></td>
						<td>
						<span id="content_documentacion">
							<?php include_partial('documentacion_grupos/selectByGrupoTrabajo', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$sf_user->getAttribute('archivos_d_g_nowdocumentacion'))) ?>
			      </span>
						</td>
					</tr>
					<tr>
					<td width="29%"><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('archivos_d_g_nowdesde');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
					<td style="padding-top: 5px;">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('archivos_d_g_nowhasta');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				</tr>
				<tr><td height="5"></td></tr>
				<tr>
					<td>
						<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
					</td>
					<td>
					  <?php if ($cajaBsq || $grupoBsq || $documentacionBsq || $desdeBsq || $hastaBsq): ?>
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
