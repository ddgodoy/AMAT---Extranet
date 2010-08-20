<?php 
	use_helper('TestPager');
	use_helper('Security','Object');
?>
<?php if($grupoBsq){
$redireccionGrupo = 'grupo='.$grupoBsq;
}else{
$redireccionGrupo = '';
} ?>
<div class="mapa">
	<strong>Grupos de Trabajo</strong> > Documentaci&oacute;n
</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Documentaci&oacute;n de Grupos de Trabajo</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'DocumentacionGrupo'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
			<strong class="subtitulo" style="float:left; margin-right:10px;">Documentaci&oacute;n General</strong>
			<?php if ($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('documenatcion_grupos_trabajo/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Fecha</a>
					</th>
					<th width="35%">
						<a href="<?php echo url_for('documenatcion_grupos_trabajo/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Titulo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('documenatcion_grupos_trabajo/index?sort=grupo_trabajo_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Grupo de Trabajo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('documenatcion_grupos_trabajo/index?sort=user_id_creador&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Creado por</a>
					</th>
					<th width="5%"></th>
					</tr>
					<?php $i=0; foreach ($documentacion_grupo_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris';?>
					<?php include_partial('ListaByGrupoTrabajo', array('valor'=>$valor,'odd'=>$odd, 'redireccionGrupo'=>$redireccionGrupo, 'responsable'=>$resposable));?>			
					<?php endforeach; ?>
					<tr>
					<td>
					</td>
					</tr>
			</tbody>
		</table>
		<div class="clear"></div>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay registros cargados</div>
			<?php endif; ?>
		<?php endif; ?>
 
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Documento/s </span>
		</div>	
</div>	
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('documenatcion_grupos_trabajo/index?'.$redireccionGrupo) ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="29%"><label>T&iacute;tulo:</label></td>
						<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/></td>
					</tr>

					<tr>
					<td><label>Contenido:</label></td>
					<td valign="middle">
						<?php echo input_tag('contenido_busqueda',
					     $contenidoBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:70%;','class'=>"form_input"))?>
					</td>
				    </tr>

					<tr>
						<td width="29%"><label>Grupo de trabajo:</label></td>
                                                <td><?php echo select_tag('grupo', options_for_select(array('0'=>'--Seleccionar--')+ _get_options_from_objects(GrupoTrabajoTable::getAllGrupoTrabajo()),$grupoBsq),array('style'=>"width:150px;"))?></td>
					</tr>
					<tr>
						<td width="29%"><label>Categor&iacute;a:</label></td>
						<td><?php echo select_tag('categoria_busqueda',options_for_select(array('0'=>'--Seleccionar--')+ _get_options_from_objects(CategoriaDGTable::getAllcategoria()),$categoriaBsq),array('style'=>"width:150px;"))?></td>
					</tr>
					<tr>
						<td style="padding-top:5px;"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></td>
						<td>
						  <?php if ($cajaBsq || $grupoBsq || $categoriaBsq || $contenidoBsq): ?>
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