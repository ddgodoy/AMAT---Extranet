<?php
	use_helper('TestPager');
	use_helper('Security');
?>
<div class="mapa"><strong>Administraci&oacute;n</strong> > Actas- <?php echo $DAtos['busqueda']?></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Actas</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
   
       <?php  $id_organismos = !empty ($organismomenu)?$organismomenu:''; include_component('miembros_organismo_lista','MenuOrganismos',array('id' => $id_organismos,'modulo'=>$modulo)); ?>


	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $DAtos['get'])?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Acta/s</span>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="20%" style="text-align:center;">
						<a href="<?php echo url_for('acta_organismos_lista/index?'.$DAtos['get'].'&sort=created_at&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Alta</a>
					</th>
					<th width="40%">
						<a href="<?php echo url_for('acta_organismos_lista/index?'.$DAtos['get'].'&sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nombre</a>
					</th>
					<th width="40%">
					<a href="<?php echo url_for('acta_organismos_lista/index?'.$DAtos['get'].'&sort=asamblea_id&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Asamblea</a>
					</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($acta_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td valign="top" align="center">
						<?php echo date("d/m/Y [H:i]", strtotime($valor->getCreatedAt())) ?>
					</td>
					<td valign="top">
						<a href="<?php echo url_for('acta_organismos_lista/ver?id=' . $valor->getId().'&'.$DAtos['get']) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					</td>
					<td valign="top" ><?php echo $valor->Asamblea->getTitulo() ?></td>
          <td valign="top" align="center"></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Actas registradas</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
		        <?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $DAtos['get']) ?></div>
     			<?php endif; ?>
                 <span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Acta/s </span>
		    </div>
		<?php endif; ?>
                                <span class="botonera"><input type="button" class="boton" value="Volver" name="btn_quitar" onclick="javascript:history.back(1)"/></span>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('acta_organismos_lista/index?'.$DAtos['get']) ?>">
			<input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
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
					<?php if($DAtos['busqueda'] != ''):?>
					<tr>
					 <td><?php echo $DAtos['busqueda'] ?></td>
					 <td><?php include_component('organismos_lista','listaorganismos',array('grupodetrabajoBsq' => $grupodetrabajoBsq));?></td>
					</tr>
					<?php endif;?>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
						<?php if ($cajaBsq || $grupodetrabajoBsq ): ?>
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