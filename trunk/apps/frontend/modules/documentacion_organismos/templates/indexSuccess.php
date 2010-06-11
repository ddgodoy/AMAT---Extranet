<?php

	use_helper('TestPager');
	use_helper('Security');
	use_helper('Javascript');
	use_helper('Object');

	// datos  utiles para los partial
  $modulo = $sf_context->getModuleName();
  $categoria = $sf_user->getAttribute($modulo.'_nowcategoria')? $sf_user->getAttribute($modulo.'_nowcategoria') : '' ;
  $subcategoria = $sf_user->getAttribute($modulo.'_nowsubcategoria')? $sf_user->getAttribute($modulo.'_nowsubcategoria') : '' ;
  $arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($categoria);
  $arrayOrganismo = $subcategoria? OrganismoTable::doSelectByOrganismoa($subcategoria) : '';
  $subcategoria_organismos_selected = $sf_user->getAttribute($modulo.'_nowsubcategoria');
  $organismos_selected = $sf_user->getAttribute($modulo.'_noworganismos');
?>
<?php if($organismoBsq):
$redireccionGrupo = Organismo::getUrlOrganismos($organismoBsq);
else :
$redireccionGrupo = '';
endif; ?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('documentacion_organismos/publicar?'.$redireccionGrupo) ?>';
		var rutaToDel = '<?php echo url_for('documentacion_organismos/delete?'.$redireccionGrupo) ?>';
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
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<div class="mapa"><strong>Organismos</strong> > Documentación</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Documentación de Organismos</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'DocumentacionOrganismo'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
	
	<?php if($organismoBsq): include_component('miembros_organismo','MenuOrganismos',array('id' => $organismoBsq,'modulo'=>$modulo)); endif;    ?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<strong class="subtitulo" style="float:left; margin-right:10px;">Documentaci&oacute;n General</strong> <!--<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Documento/s </span>-->
               <?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
     			<?php endif; ?>
                <?php if(validate_action('alta')):?>
                                <input type="button" onclick="javascript:location.href='<?php echo url_for('documentacion_organismos/nueva?hola[chau]=30') ?>';" style="float: right;" value="Nueva Documentación" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="" id="frmListDocOrganismos">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<?php if(validate_action('publicar') || validate_action('baja') ):?>
					<th width="5%">&nbsp;</th>
					<?php endif;?>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('documentacion_organismos/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Fecha</a>
					</th>
					<th width="35%">
						<a href="<?php echo url_for('documentacion_organismos/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Titulo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('documentacion_organismos/index?sort=organismo_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Organismo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('documentacion_organismos/index?sort=user_id_creador&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Creado por</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%"><?php if ( validate_action('publicar')): ?>Publicar<?php endif;?></th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($documentacion_organismo_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
					<?php if(validate_action('publicar') || validate_action('modificar') || validate_action('baja') ):?>
				    <?php if($valor->getEstado() == 'guardado'):?>
					<?php if($valor->getUserIdCreador() == $sf_user->getAttribute('userId')):?>
					<?php include_partial('ListaByOrganismo', array('valor'=>$valor,'odd'=>$odd, 'redireccionGrupo'=>$redireccionGrupo));?>
					<?php endif; ?>
					<?php else: ?>
					<?php include_partial('ListaByOrganismo', array('valor'=>$valor,'odd'=>$odd, 'redireccionGrupo'=>$redireccionGrupo ));?>
					<?php endif; ?>
					<?php else: ?>
					<?php if($valor->getEstado() == 'guardado' || $valor->getEstado() == 'pendiente'):?>
					<?php if($valor->getUserIdCreador() == $sf_user->getAttribute('userId')):?>
					<?php include_partial('ListaByOrganismo', array('valor'=>$valor,'odd'=>$odd, 'redireccionGrupo'=>$redireccionGrupo));?>
					<?php endif; ?>
					<?php else: ?>
					<?php include_partial('ListaByOrganismo', array('valor'=>$valor,'odd'=>$odd, 'redireccionGrupo'=>$redireccionGrupo));?>
					<?php endif; ?>
				    <?php endif;?>
					<?php endforeach; ?>
				<tr>
				<td>
				<?php if(validate_action('publicar') || validate_action('baja') ):?>
				<input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/>
				<?php endif;?>
				</td>
				<td colspan="5">
					<?php if(validate_action('publicar')):?>
					<input type="submit" class="boton" value="Publicar seleccionados" name="btn_publish_selected" onclick="return setActionFormList('publicar');"/>
					<?php endif; ?>
					<?php if(validate_action('baja')):?>
					<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" style="margin-left:5px;"/>
					<?php endif;?>
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

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('documentacion_organismos/nueva?'.$redireccionGrupo) ?>';" style="float: right;" value="Nueva Documentación" name="newNews" class="boton"/>
			<?php endif;?>
			
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('documentacion_organismos/index?'.$redireccionGrupo) ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td>Titulo</td>
						<td>
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
		<td><label> Categoría *</label></td>
		<td valign="middle">
		<?php
		// llamo al componente del modulo  categoria _ organismos
		   echo include_component('categoria_organismos','listacategoria',array('name'=>'documentacion_organismo'));
		?>
		</td>
		</tr>
		<tr>
		<td><label> Subcategoría *</label></td>
		<td valign="middle">
		<span id="content_subcategoria">
		<?php 
		// llamo al partial que se encuentra subcategoria _ organismos/selectByCategoriaOrganismo para que luego lo reescriba el componente del modulo  categoria _ organismos
		include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected,'name'=>'documentacion_organismo')); 
		?>
		</span>
		
		</td>
		</tr>
        <tr>
          <td><label>Organismo *</label></td>
          <td valign="middle">
          <span id="content_organismos">              
          	<?php 
          	// llamo al partial que se encuentra organismos/listByOrganismos para que luego lo reescriba el componente del modulo  subcategoria _ organismos
          	include_partial('organismos/listByOrganismos', array ('arrayOrganismo'=>$arrayOrganismo, 'organismos_selected'=>$organismos_selected,'name'=>'documentacion_organismo'))           	
          	?>
          </span>    
          </td>
        </tr>
        <?php if(validate_action('publicar') || validate_action('modificar') || validate_action('baja')):?>
        <tr>
			<td style="padding-top: 5px;"><label>Estado:</label></td>
			<td style="padding-top: 5px;">
			<?php echo select_tag('estado_busqueda',options_for_select(array('0'=>'--seleccionar--','guardado'=>'Guardado','pendiente'=>'Pendiente','publicado'=>'Publicado'),$estadoBsq),array('style'=>"width:150px;"))?>
	  		</td>
		</tr>
		<?php endif; ?>
        <tr>
		<td width="29%"><label>Fecha Desde:</label></td>
		<td width="71%" valign="middle">
			<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('documentacion_organismos_nowdesde');?>" class="form_input"/>
			<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
			</td>
		</tr>
		<tr>
			<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
			<td style="padding-top: 5px;">
				<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('documentacion_organismos_nowhasta');?>" class="form_input"/>
				<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
			</td>
		</tr>
			<tr>
				<td style="padding-top:5px;">
					<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>
					</td>
					<td>	
					<?php if ($cajaBsq || $categoriaBsq || $subcategoriaBsq || $organismoBsq || $desdeBsq || $hastaBsq): ?>
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
