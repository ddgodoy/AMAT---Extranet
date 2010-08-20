<?php use_helper('TestPager') ?>
<?php use_helper('Security','Object') ?>


<div class="mapa"><strong>Administraci&oacute;n</strong> &gt Normas de Funcionamiento</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Normas de Funcionamiento</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'NormasDeFuncionamiento'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
		    <div class="lineaListados">
                        <strong class="subtitulo" style="float:left; margin-right:10px;">Normas de Funcionamiento</strong> <!--<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Documento/s </span>-->
                        <?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
     			<?php endif; ?>
		    </div>
		</div>
    <?php if ($cantidadRegistros > 0) : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
	<tbody>
		<tr>
			<th width="50%">
				<a href="<?php echo url_for('normas_de_funcionamiento_grupos/index?sort=titulo&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Titulo</a>
			</th>
		</tr>
    <?php $i=0; foreach ($normas_de_funcionamiento_list as $normas_de_funcionamientos): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
	    <tr class="<?php echo $odd ?>">
                  <td><a href="<?php echo url_for('normas_de_funcionamiento_grupos/show?id='.$normas_de_funcionamientos->getId()) ?>"><?php echo $normas_de_funcionamientos->getTitulo() ?></a></td>
	    </tr>
    <?php endforeach; ?>
  </tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Normas registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Normas de Funcionamiento</span>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('normas_de_funcionamiento_grupos/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="10%">
					Nombre
					</td>
						<td width="90%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<td width="29%"><label>Grupo de trabajo:</label></td>
						<td>
							<?php echo select_tag('grupo',options_for_select(array('0'=>'--Seleccionar--')+ _get_options_from_objects(GrupoTrabajoTable::getAllGrupoTrabajo()),$grupo),array('style'=>"width:150px;"))?>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
						<?php if ($cajaBsq || $grupo ): ?>
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