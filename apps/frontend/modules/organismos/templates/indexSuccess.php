<?php use_helper('TestPager') ?>
<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php use_helper('Object');
$arraySubcategoria = array();
if ($sf_user->getAttribute('organismos_nowcategoria'))
	{
		$arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($sf_user->getAttribute('organismos_nowcategoria'));
	}
	$modulo = $sf_context->getModuleName();
	$subcategoria_organismos_selected = $sf_user->getAttribute($modulo.'_nowsubcategoria');
?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('organismos/publicar') ?>';
		var rutaToDel = '<?php echo url_for('organismos/delete') ?>';
		var objectFrm = $('frmListDocOrganismos');

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
<div class="mapa"><strong>Organismos</strong> > Gestión de Organismos</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Gestión de Organismos</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Organismo'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

	<div class="leftside grupos-de-trabajo"">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	   		<?php endif; ?>

        	<h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Organismo/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('organismos/nueva') ?>';" style="float: right;" value="Nuevo Organismo" name="newNews" class="boton"/>
			<?php endif; ?>

		</div>
		<br />
		<?php if ($cantidadRegistros > 0) : ?>
                <form method="post" enctype="multipart/form-data" action="" id="frmListDocOrganismos">
				<?php $i=0; foreach ($organismo_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<a href="<?php echo url_for('miembros_organismo/index?organismo='.$valor->getId()) ?>" class="grupo-titulo"> <strong><?php echo $valor->getCategoriaOrganismo()->getNombre().' '.$valor->getSubCategoriaOrganismo()->getNombre().' '.$valor->getNombre()?></strong><span>Creado el: <?php echo date('d/m/Y',strtotime($valor->getCreatedAt()))?></span> </a><br />
			      <table width="100%"  cellspacing="0" cellpadding="0" border="0" class="listados descrip-grupo">      
			        <tr class="gris">
                                 <td width="5%">
                                    <?php if(validate_action('baja')): ?>
                                            <input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" />
                                    <?php else: ?>
                                            &nbsp;
                                    <?php endif;?>
                                 </td>
			        <?php if($valor->getDetalle()):?>
			          <td><?php echo $valor->getDetalle()?></td>
			        <?php else: ?>
			          <td valign="top" align="center" class="doc">  </td>
			          <td width="95%" align="left">&nbsp;&nbsp;</td> 
			         <?php endif; ?>  
			         <td  width="5%" valign="middle" align="center">
                                  <?php if(validate_action('modificar')):?>
                                   <a href="<?php echo url_for('organismos/editar?id=' . $valor->getId()) ?>">
                                         <?php echo image_tag('edit.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?>
                                    </a>
                                     <?php endif;?>
                                   </td>
			           <td width="5%" valign="middle" align="center">
			          <?php if(validate_action('baja')):?>
			          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'organismos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
			          <?php endif;?>	
			          </td>
			        </tr>
			    </table><br />
				<?php endforeach; ?>
                            <?php if(validate_action('baja')):?>
                              <div class="lineaListados">
                                  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados descrip-grupo">
                                   <tr class="gris">
                                    <td width="3%"><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
                                    <td>
                                    <input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" />
                                    </td>
                                   </tr>
                                 </table>
                             </div>
                            <?php endif;?>
                    </form>
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

        	<h2 class="grupo" style="float:left; line-height:30px; width:auto; border:none;">&nbsp;</h2>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Organismo/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('organismos/nueva') ?>';" style="float: right;" value="Nuevo Organismo" name="newNews" class="boton"/>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('organismos/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td>Titulo</td>
					<td>
						
					<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						
					</td>
					</tr>
					<tr>
					<td><label> Categoría </label></td>
					<td valign="middle">
					<?php
					// llamo al componente del modulo  categoria _ organismos
					   echo include_component('categoria_organismos','listacategoria',array('name'=>'organismo'));
					?>
					</td>
					</tr>
					<tr>
					<td><label> Subcategoría </label></td>
					<td valign="middle">
					<span id="content_subcategoria">
					<?php 
					// llamo al partial que se encuentra subcategoria _ organismos/selectByCategoriaOrganismo para que luego lo reescriba el componente del modulo  categoria _ organismos
					include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected,'name'=>'organismo')); 
					?>
					</span>
					
					</td>
					</tr>
					<tr>
					<td style="padding-top:5px;">
						<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
					</td>
					<td>
					<?php if ($cajaBsq ||  $categoriaBsq || $subcategoriaBsq ): ?>
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

