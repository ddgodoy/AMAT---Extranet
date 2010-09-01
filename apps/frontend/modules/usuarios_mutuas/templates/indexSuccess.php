<?php
	use_helper('TestPager');
	use_helper('Security','Object');
?>
<script type="text/javascript" src="/js/common_functions.js"></script>

<div class="mapa"><strong>Administraci&oacute;n</strong> &gt Usuarios Mutua: <?php echo $sf_user->getAttribute('mutua'); ?></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Usuarios Mutua: <?php echo $sf_user->getAttribute('mutua'); ?></h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Usuario_mutuas'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar excel', 'alt' => 'Exportar excel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Usuario/s</span>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados" >
			<tbody>
				<tr>
                                        <th width="30%" style="text-align:left;">
						<a href="<?php echo url_for('usuarios_mutuas/index?sort=apellido&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Apellido</a>,
						<a href="<?php echo url_for('usuarios_mutuas/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nombre</a>
					</th>
					<th width="30%">Grupos de Trabajo</th>
					<th width="30%">Consejo Territorial</th>
                                        </tr>
                                        <?php $i=0; foreach ($usuario_list as $value): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
                                        <tr class="<?php echo $odd ?>">
                                        <td valign="middle">
					<strong><?php echo $value->getApellido() ?>, <?php echo $value->getNombre() ?></strong>
					</td>
                                        <td><?php $arrayGrupo = GrupoTrabajo::ArrayDeMigrupo($value->getId()); foreach ($arrayGrupo as $K=>$g){echo $g.'<br>';}?></td>
                                        <td><?php $arrayConsejo = ConsejoTerritorial::ArrayDeMiconsejo($value->getId()); foreach ($arrayConsejo as $L=>$c){echo $c.'<br>';}?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq || $cajaGruBsq || $cajaConBsq) : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Usuarios registrados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Usuario/s</span>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre &oacute; Usuario</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('usuarios_mutuas/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="20%">Texto</td>
					<td width="80%">
					<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
					</td>
					</tr>
					<tr>
					<td width="20%">Grupo de trabajo</td>
					<td width="80%">
					 <?php echo select_tag('grupo',options_for_select( _get_options_from_objects(GrupoTrabajoTable::getAllGrupoTrabajo()),$cajaGruBsq),array('multiple' => 'true',
'size' => 8,'style'=>'width:200px'));?>
					</td>
					</tr>
					<tr>
					<td width="20%">Consejo territorial</td>
					<td width="80%">
					<?php echo select_tag('consejo',options_for_select(_get_options_from_objects(ConsejoTerritorialTable::getAllconsejo()),$cajaConBsq),array('multiple' => 'true',
'size' => 8,'style'=>'width:200px'));?>
					</td>
					</tr>
					<tr>
					<td style="padding-top:5px;">
					<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
					</td>
					<td style="padding-top:5px;">
					<?php if ($cajaBsq || $cajaGruBsq || $cajaConBsq ): ?>
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