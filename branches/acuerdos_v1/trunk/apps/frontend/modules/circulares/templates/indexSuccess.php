<?php use_helper('TestPager','Object') ?>
<?php use_helper('Security','Javascript') ?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa"><strong>Administraci&oacute;n</strong> > Circulares</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Circulares</h1></td>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Circular/es</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('circulares/nueva') ?>';" style="float: right;" value="Crear Nueva Circular" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
				    <th width="10%" style="text-align:center;">
						<a href="<?php echo url_for('circulares/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="5%" style="text-align:center;">
					    <a href="<?php echo url_for('circulares/index?sort=numero&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nº</a>
					</th>
					<th width="75%">
						<a href="<?php echo url_for('circulares/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($circular_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
				    <td valign="top" align="center">
						<?php echo date("d/m/Y", strtotime($valor->getfecha())) ?>
					</td>
                                        <td valign="top" align="center">
						<?php echo $valor->getNumero() ?>
					</td>
					<td valign="top">
						<a <?php if(validate_action('listar')):?> href="<?php echo url_for('circulares/show?id=' . $valor->getId()) ?>" <?php endif;?>>
							<strong><?php echo $valor->getNombre() ?></strong>		
						</a>
					</td>
					<td valign="top" align="center">
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('circulares/editar?id=' . $valor->getId()) ?>">
							<?php echo image_tag('edit.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
					<?php endif;?>		
						</a>
					</td>
                                        <td valign="top" align="center">
                                            <?php if(validate_action('baja')):?>
                                            <?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'circulares/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
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
				<div class="mensajeSistema comun">No hay Circulares registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Circular/es</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('circulares/nueva') ?>';" style="float:right;margin-top:10px;" value="Crear Nueva Circular" name="newNews" class="boton"/>
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
	   'arrayCategoriasTema'=>$arrayCategoriasTema, 
	   'SelectCatTemaBsq'=>$SelectCatTemaBsq, 
	   'SelectSubTemaBsq'=>$SelectSubTemaBsq, 
	   'SelectSubTemaBsq2'=>'', 
	   'arrayCategoria'=>'',
	   'SelectCatOrganismoBsq'=>'',
	   'SelectSubOrganismoBsq'=>''))?>
		<div class="paneles">
			<h1>Buscador de circulares</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('circulares/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
				    <tr>
					<td width="30%">
					Nº de Circular
					</td>
					<td width="70%">
				     <?php echo input_tag('n_busqueda',
				     $sf_user->getAttribute('circulares_nownumero'),array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:60%;','class'=>"form_input"))?>
					</td>
					</tr>	
					<tr>
					<td width="30%">
					Titulo
					</td>
					<td width="70%">
				     <?php echo input_tag('caja_busqueda',
				     $sf_user->getAttribute('circulares_nowcaja'),array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:60%;','class'=>"form_input"))?>
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
					     $sf_user->getAttribute('circulares_nowfechadesde'),array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				    </tr>
				    <tr>
					<td><label>Fecha Hasta:</label></td>
					<td valign="middle">
						<?php echo input_tag('hasta_busqueda',
					     $sf_user->getAttribute('circulares_nowfechahasta'),array('onblur'=>"this.style.background='#E1F3F7'","onfocus"=>"this.style.background='#D5F7FF'",'style'=>'width:30%;','class'=>"form_input"))?>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				    </tr>
				    <tr>
					<td valign="top"><label>Categor&iacute;a de Tema</label></td>
					<td valign="middle">
						<?php
							echo select_tag('select_cat_tema',
							options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayCategoriasTema), $SelectCatTemaBsq),
							array('style'=>'width:250px;','class'=>'form_input'));
							echo observe_field('select_cat_tema', array('update'=>'content_sub_tema','url'=>'circular_sub_tema/listByCategoria','with'=>"'id_categoria='+value+'&name=circular'"));
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><label>Subcategor&iacute;a de Tema</label></td>
					<td valign="middle">
						<span id="content_sub_tema">
							<?php include_partial('circular_sub_tema/selectByCategoria', array ('arraySubcategoriasTema'=>$arraySubcategoriasTema, 'sub_tema_selected'=>$SelectSubTemaBsq, 'name'=>'circular')) ?>
						</span>
					</td>
				</tr>
				<?php /*
                                <tr>
					<td valign="top"><label>Categor&iacute;a de Organismo</label></td>
					<td valign="middle">
						<?php
							echo select_tag('categoria_organismo_id',
							options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayCategoria),
							$SelectCatOrganismoBsq), array('style'=>'width:250px;','class'=>'form_input'));
							echo observe_field('categoria_organismo_id', array('update'=>'content_sub_org','url'=>'subcategoria_organismos/listByCategoriaOrganismo','with'=>"'id_categoria_organismo='+value+'&name=circular'"));
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><label>Subcategor&iacute;a de Organismo</label></td>
					<td valign="middle">
						<span id="content_sub_org">
							<?php  include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$SelectSubOrganismoBsq,'name'=>'circular')) ?>
						</span>
					</td>
				</tr>
                                */ ?>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td>
						<?php if ($nBsq || $cajaBsq || $desdeBsq || $SelectCatTemaBsq || $SelectSubTemaBsq || $SelectCatOrganismoBsq || $SelectSubOrganismoBsq): ?>
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