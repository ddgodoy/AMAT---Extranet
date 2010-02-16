<?php
	use_helper('TestPager');
	use_helper('Security','Object');
?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('documentacion_grupos/publicar') ?>';
		var rutaToDel = '<?php echo url_for('documentacion_grupos/delete') ?>';
		var objectFrm = $('frmListDocGrupos');

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

<div class="mapa">
	<strong>Grupos de Trabajo</strong> > Documentación
</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Documentación de Grupos de Trabajo</h1></td>
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

  <?php  include_partial('miembros_grupo/MenuGrupo',array('Grupo' => $Grupo, 'modulo'=>$modulo))?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

<div class="leftside">
	<div class="lineaListados">
		<div class="lineaListados">
			<strong class="subtitulo" style="float:left; margin-right:10px;">Documentaci&oacute;n General</strong>
			<?php if ($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>
			<?php if (validate_action('alta')):?>
				<input type="button" onclick="javascript:location.href='<?php echo url_for('documentacion_grupos/nueva') ?>';" style="float: right;" value="Crear nueva documentaci&oacute;n" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="" id="frmListDocGrupos">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('documentacion_grupos/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="70%">
						<a href="<?php echo url_for('documentacion_grupos/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="70%">
						<a href="<?php echo url_for('documentacion_grupos/index?sort=user_id_creador&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Creado por</a>
					</th>
					<th width="5%"></th>
					<th width="5%">Publicar</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($documentacion_grupo_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('documentacion_grupos/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getUserIdCreador())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
					</td>
					<td valign="center" align="center">
						<?php
						if(ArchivoDG::getRepository()->getAllByDocumentacion($valor->getId())->count() >= 1){ 
							if (validate_action('listar','archivos_d_g')) { 
								echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_d_g/index?archivo_d_g[documentacion_grupo_id]=' . $valor->getId(), array('method' => 'post'));
							}
						}		
						?>
					</td>
					<td valign="center" align="center">
						<?php
							if (validate_action('publicar') && $valor->getEstado() != 'publicado') { 
								echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'documentacion_grupos/publicar?id=' . $valor->getId(), array('method' => 'post', 'confirm' => 'Confirma la publicación del registro?'));
							}	
						?>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('documentacion_grupos/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
					<?php endif; ?>	
					</td>
          <td valign="center" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'documentacion_grupos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
          <?php endif;?>	
          </td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
					<td colspan="5">
						<input type="submit" class="boton" value="Publicar seleccionados" name="btn_publish_selected" onclick="return setActionFormList('publicar');"/>
						<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" style="margin-left:5px;"/>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
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
			<?php if(validate_action('alta')):?>
				<input type="button" onclick="javascript:location.href='<?php echo url_for('documentacion_grupos/nueva') ?>';" style="float: right;" value="Crear nueva documentaci&oacute;n" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
 </div>	
</div>	
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('documentacion_grupos/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="29%"><label>T&iacute;tulo:</label></td>
						<td><input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/></td>
					</tr>
					<tr>
						<td width="29%"><label>Grupo de trabajo:</label></td>
						<td><?php echo select_tag('grupo', options_for_select(array('0'=>'--Seleccionar--')+ _get_options_from_objects(GrupoTrabajoTable::getGruposTrabajoByUsuario($sf_user->getAttribute('userId'))),$grupoBsq),array('style'=>"width:150px;"))?></td>
					</tr>
					<tr>
						<td width="29%"><label>Categor&iacute;a:</label></td>
						<td><?php echo select_tag('categoria_busqueda',options_for_select(array('0'=>'--Seleccionar--')+ _get_options_from_objects(CategoriaDGTable::getAllcategoria()),$categoriaBsq),array('style'=>"width:150px;"))?></td>
					</tr>
					<tr>
						<td style="padding-top: 5px;"><label>Estado:</label></td>
						<td style="padding-top: 5px;">
							<?php echo select_tag('categoria_busqueda',options_for_select(array('0'=>'--Seleccionar--','pendiente'=>'Pendiente','publicado'=>'Publicado'),$estadoBsq),array('style'=>"width:150px;"))?>
				  	</td>
					</tr>
					<tr>
						<td style="padding-top:5px;"><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></td>
						<td>
						  <?php if ($cajaBsq || $grupoBsq || $categoriaBsq || $estadoBsq): ?>
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