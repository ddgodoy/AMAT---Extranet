<?php
	use_helper('TestPager');
	use_helper('Security');
	use_helper('Date');
?>
<div class="mapa"><strong>Administraci&oacute;n</strong> > Consejos Territoriales</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Consejos Territoriales</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'ConsejoTerritorial'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

<div class="leftside grupos-de-trabajo">
		<div class="lineaListados">
        	<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	   		<?php endif; ?>

        	<h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Consejo/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('consejos_territoriales/nueva') ?>';" style="float: right;" value="Crear Nuevo Consejo" name="newNews" class="boton"/>
			<?php endif;?>
</div>
<br />
		<?php if ($cantidadRegistros > 0) : ?>
			<?php $i=0; foreach ($consejos_territoriales_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
			   <a href="<?php echo url_for('miembros_consejo/index?consejo='.$valor->getId()) ?>" class="grupo-titulo"> <strong><?php echo $valor->getNombre()?></strong><span>Creado el: <?php echo date('d/m/Y',strtotime($valor->getCreatedAt()))?></span> </a><br />

			      <table width="100%"  cellspacing="0" cellpadding="0" border="0" class="listados descrip-grupo">      
			        <tr class="gris">
			        <?php if($valor->getDetalle()):?>
			          <td><?php echo $valor->getDetalle()?></td>
			        <?php else: ?>
			         <td valign="top" align="center" class="doc">  </td>
			          <td width="95%">&nbsp;&nbsp;</td> 
			         <?php endif; ?>  
			         <td width="5%" valign="middle" align="center">
					  <?php if(validate_action('modificar')):?>
					   <a href="<?php echo url_for('consejos_territoriales/editar?id=' . $valor->getId()) ?>">
						 <?php echo image_tag('edit.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
					    </a>
					     <?php endif;?>	
					   </td>
			           <td width="5%" valign="middle" align="center">
			          <?php if(validate_action('baja')):?>
			          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'consejos_territoriales/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
			          <?php endif;?>	
			          </td>
			        </tr>
			    </table><br />
		     <?php endforeach; ?>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Consejos registrados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		 <div class="lineaListados">
	        <?php if($pager->haveToPaginate()): ?>
					<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		   <?php endif; ?>
	
	        <h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
	        <span style="float: left;" class="info">Hay <?php echo $cantidadRegistros ?> Consejo/s</span>
	        <?php if(validate_action('alta')):?>
	        <input type="button" class="boton" name="newNews" value="Crear Nuevo Consejo" style="float: right;" onclick="javascript:location.href='<?php echo url_for('consejos_territoriales/nueva') ?>';"/>
	        <?php endif;?>
	     </div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('consejos_territoriales/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="20%">
					Nombre
					</td>
						<td width="80%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr><td height="5"></td></tr>
					<tr>
						<td><span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span></td>
						<td>
						<?php if ($cajaBsq): ?>
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