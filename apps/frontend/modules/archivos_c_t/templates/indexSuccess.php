<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>
<?php use_helper('Object') ?>
<?php use_helper('Javascript');
$arrayDocumentacion = array();
if ($sf_user->getAttribute('archivos_c_t_nowconsejo'))
	{
		$arrayDocumentacion = DocumentacionConsejoTable::DocumentacionByConsejo($sf_user->getAttribute('archivos_c_t_nowconsejo'));
	}
else 
	{
		$arrayDocumentacion = DocumentacionConsejoTable::getAlldocumentacionC();
	}
?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa"><strong>Consejos Territoriales</strong><?php if($documentacion !=''):?> > Documentacion: <?php echo $documentacion->getNombre(); endif;?> > Archivos</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Archivos de <?php if($documentacion !=''):?>Documentacion: <?php echo $documentacion->getNombre(); else: ?>Consejos Territoriales<?php endif; ?></h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'ArchivoCT'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('archivos_c_t/nueva') ?>';" style="float: right;" value="Nuevo Archivo" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('archivos_c_t/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="70%">
						<a href="<?php echo url_for('archivos_c_t/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="70%">
						<a href="<?php echo url_for('archivos_c_t/index?sort=owner_id&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Creado por</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($archivo_ct_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('archivos_c_t/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php if($valor->getOwnerId()):?>
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getOwnerId())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
						<?php endif;?>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('archivos_c_t/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
					<?php endif;?>	
					</td>
          <td valign="center" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'archivos_c_t/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
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
				<div class="mensajeSistema comun">No hay registros cargados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('archivos_c_t/nueva') ?>';" style="float: right;" value="Nuevo Archivo" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('archivos_c_t/index') ?>">
				<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td>Titulo</td>
						<td>
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<td width="29%"><label>Consejos Territoriales:</label></td>
						<td>
						<?php 
							echo select_tag('consejo_territorial_id',
															options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(ConsejoTerritorialTable::getAllconsejo()), $sf_user->getAttribute('archivos_c_t_nowconsejo')),
															array('style'=>'width:200px;','class'=>'form_input')
														 );
							echo observe_field('consejo_territorial_id', array('update'=>'content_documentacion','url'=>'archivos_c_t/listDocumentacion','with'=>"'id_consejo='+value"));
							
			      ?>
						</td>
					</tr>
						<tr>
					<td width="29%"><label>Documentaci&oacute;n:</label></td>
						<td>
						<span id="content_documentacion">
							<?php include_partial('archivos_c_t/listDocumentacion', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$sf_user->getAttribute('archivos_c_t_nowdocumentacion'))) ?>
			      </span>
						</td>
					</tr>
					<tr>
					<td width="29%"><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('archivos_c_t_nowdesde');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
					<td style="padding-top: 5px;">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('archivos_c_t_nowhasta');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				</tr>
					<tr>
						<td style="padding-top:5px;">
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
			</table>
			</form>
		</div>
	</div>
<!-- * -->
<div class="clear"></div>

