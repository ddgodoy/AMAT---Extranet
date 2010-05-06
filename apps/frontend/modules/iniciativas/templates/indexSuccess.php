<?php
	use_helper('TestPager', 'Object');
	use_helper('Security', 'Javascript');
?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Iniciativas </div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Iniciativas</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Iniciativa'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Iniciativa/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('iniciativas/nueva') ?>';" style="float: right;" value="Crear Nueva Iniciativa" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('iniciativas/delete') ?>">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
                                        <?php if(validate_action('baja')): ?>
					<th width="3%">&nbsp;</th>
                                        <?php endif; ?>
					<th width="10%" style="text-align:center;">
						<a href="<?php echo url_for('iniciativas/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="77%">
						<a href="<?php echo url_for('iniciativas/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($iniciativa_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
                                        <?php if(validate_action('baja')): ?>
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
                                        <?php endif; ?>
					<td valign="top" align="center">
						<?php echo date("d/m/Y", strtotime($valor->getfecha())) ?>
					</td>
					<td valign="top">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('iniciativas/show?id=' . $valor->getId()) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif; ?>	
					</td>
					<td valign="top" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('iniciativas/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
					<?php endif;?>		
						</a>
					</td>
                                      <td valign="top" align="center">
                                      <?php if(validate_action('baja')): ?>
                                            <?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'iniciativas/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
                                      <?php endif; ?>
                                      </td>
				</tr>
				<?php endforeach; ?>
                                <?php if (validate_action('baja')): ?>
				<tr>
					<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
					<td colspan="5"><input type="submit" class="boton" value="Borrar seleccionados" onclick="return confirm('Confirma la eliminaci&oacute;n de los registros seleccionados?');"/></td>
				</tr>
                                <?php endif; ?>
			</tbody>
		</table>
		</form>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Iniciativas Formativas registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Iniciativa/s</span>
		   
		<?php if(validate_action('alta')):?>
		<input type="button" onclick="javascript:location.href='<?php echo url_for('iniciativas/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Iniciativa" name="newNews" class="boton"/>
		<?php endif; ?>	
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
	<?php echo include_partial('inicio/NavegacionGuiada',
        array('FEcha_circulares'=>$FEcha_circulares,
	   'modulo'=>$modulo,
	   'year'=>$year,
	   'months'=>$months,
	   'arrayCategoriasTema'=>CircularTable::doSelectAllCategorias('CategoriaIniciativa'), 
	   'SelectCatTemaBsq'=>$CatInicBsq, 
	   'SelectSubTemaBsq'=>$SubIniBsq, 
	   'SelectSubTemaBsq2'=>'', 
	   'arrayCategoria'=>'', 
	   'SelectCatOrganismoBsq'=>'', 
	   'SelectSubOrganismoBsq'=>''))?>    
		<div class="paneles">
			<h1>Buscar por Titulo</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('iniciativas/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="30%">
					Titulo
					</td>
						<td width="70%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
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
					<td valign="top"><label>Categor&iacute;a de Iniciativas</label></td>
					<td valign="middle">
						<?php echo select_tag('select_cat_tema',
							options_for_select(CategoriaIniciativa::getArrayCategoria(), $CatInicBsq),
							array('style'=>'width:120px;','class'=>'form_input'));
							echo observe_field('select_cat_tema', array('update'=>'content_sub_tema','url'=>'iniciativas/subcategorias','with'=>"'id_categoria='+value")) ?>
					</td>
				</tr>
				<tr>
					<td valign="top"><label>Subcategor&iacute;a de Iniciativas</label></td>
					<td valign="middle">
						<span id="content_sub_tema">
							<?php include_component('iniciativas','subcategorias',array('id_categoria'=>$CatInicBsq, 'id_subcategoria'=>$SubIniBsq));?>
						</span>
					</td>
				</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ($cajaBsq || $desdeBsq || $hastaBsq || $CatInicBsq || $SubIniBsq || $contenidoBsq): ?>
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