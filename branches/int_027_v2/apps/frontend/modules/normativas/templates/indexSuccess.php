<?php use_helper('TestPager','Javascript') ?>
<?php use_helper('Security') ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa"><strong>Administraci&oacute;n</strong> &gt Normativas</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Normativas</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Normativa'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Normativa/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('normativas/nueva') ?>';" style="float: right;" value="Crear Nueva Normativa" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="15%" style="text-align:center;">
						<a href="<?php echo url_for('normativas/index?sort=n.fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="60%">
						<a href="<?php echo url_for('normativas/index?sort=n.nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="15%" style="text-align:center;">
						<a href="<?php echo url_for('normativas/index?sort=n.publicacion_boe&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Publicacion BOE</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($normativa_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="top" align="center">
						<?php echo date("d/m/Y", strtotime($valor->getfecha())) ?>
					</td>
					<td valign="top">
						<a href="<?php echo url_for('normativas/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					</td>
					<td valign="top" align="center">
					<?php if($valor->getPublicacionBoe()):?>
						<?php echo date("d/m/Y", strtotime($valor->getPublicacionBoe())) ?>
					<?php endif; ?>	
					</td>
					<td valign="top" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('normativas/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
						</a>
					<?php endif; ?>	
					</td>
          <td valign="top" align="center">
          <?php if(validate_action('baja')):?>
          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'normativas/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
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
				<div class="mensajeSistema comun">No hay Normativas registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Normativa/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('normativas/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Normativa" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
	<?php
        if($normativaCoun>=1){
        echo  include_partial('inicio/NavegacionGuiada',
        array('FEcha_circulares'=>$FEcha_circulares,
	   'modulo'=>$modulo,
	   'year'=>$year,
	   'months'=>$months,
	   'arrayCategoriasTema'=>CircularTable::doSelectAllCategorias('CategoriaNormativa'), 
	   'SelectCatTemaBsq'=>$CatNormBsq, 
	   'SelectSubTemaBsq'=>$SubNormBsq1, 
	   'SelectSubTemaBsqDos'=>$SubNormBsq2, 
	   'arrayCategoria'=>'', 
	   'SelectCatOrganismoBsq'=>'', 
	   'SelectSubOrganismoBsq'=>''));}?>
		<div class="paneles">
			<h1>Buscar por Titulo</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('normativas/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="30%">
					Titulo
					</td>
						<td width="70%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:70%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<td><label>Contenido:</label></td>
					<td valign="middle">
						<?php echo input_tag('contenido_busqueda',
					     $contenidoBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:70%;','class'=>"form_input"))?>
					</td>
				    </tr>
					<tr>
					<td><label>Fecha Desde:</label></td>
					<td valign="middle">
						<?php echo input_tag('desde_busqueda',
					     $desdeBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				    </tr>
				    <tr>
					<td><label>Fecha Hasta:</label></td>
					<td valign="middle">
						<?php echo input_tag('hasta_busqueda',
					     $hastaBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				    </tr>
				    <tr>
					<td><label>Publicacion BOE desde:</label></td>
					<td valign="middle">
						<?php echo  input_tag('publicacion_busqueda_desde',
					     $publicacionDesdeBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('publicacion_busqueda_desde', this);"/>
					</td>
				    </tr>
				    <tr>
					<td><label>Publicacion BOE hasta:</label></td>
					<td valign="middle">
						<?php echo  input_tag('publicacion_busqueda_hasta',
					     $publicacionHastaBsq,array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('publicacion_busqueda_hasta', this);"/>
					</td>
				    </tr>
				    <tr>
					<td valign="top"><label>Categor&iacute;a</label></td>
					<td valign="middle">
						<?php echo select_tag('select_cat_tema',
							options_for_select(CategoriaNormativa::getArrayCategoria(), $CatNormBsq),
							array('style'=>'width:120px;','class'=>'form_input'));
							echo observe_field('select_cat_tema', array('update'=>'content_sub_tema','url'=>'normativas/subcategoriasn1','with'=>"'id_categoria='+value",'script'=> true)) ?>
					</td>
					</tr>
				    <tr>
					<td valign="top"><label>Subcategor&iacute;a (nivel 1)</label></td>
					<td valign="middle">
						<span id="content_sub_tema">
							<?php include_component('normativas','subcategoriasn1',array('id_categoria'=>$CatNormBsq, 'id_subcategoria1'=>$SubNormBsq1));?>
						</span>
					</td>
					</tr>
				    <tr>
					<td valign="top"><label>Subcategor&iacute;a (nivel 2)</label></td>
					<td valign="middle">
						<span id="dos">
							<?php include_component('normativas','subcategorias',array('id_categoria'=>$SubNormBsq1, 'id_subcategoria2'=>$SubNormBsq2));?>
						</span>
					</td>
					</tr>
				    <tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ($cajaBsq || $desdeBsq || $hastaBsq || $CatNormBsq || $SubNormBsq1 || $SubNormBsq2 || $publicacionDesdeBsq || $publicacionHastaBsq || $contenidoBsq): ?>
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