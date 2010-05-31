<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>
<?php use_helper('Javascript') ?>
<?php use_helper('Object') ?>
 <?php if($organismoBsq && $documentacionBsq):
$redireccionGrupo = 'archivo_d_o[documentacion_organismo_id]='.$documentacionBsq.'&archivo_d_o[organismo_id]='.$organismoBsq;
else :
$redireccionGrupo = '';
endif; ?>
<?php 
// datos  utiles para los partial

          $modulo = $sf_context->getModuleName();
		  $categoria = $sf_user->getAttribute($modulo.'_nowcategoria')? $sf_user->getAttribute($modulo.'_nowcategoria') : '' ;
		  $subcategoria = $sf_user->getAttribute($modulo.'_nowsubcategoria')? $sf_user->getAttribute($modulo.'_nowsubcategoria') : '' ;
		  $organismo = $sf_user->getAttribute($modulo.'_noworganismos')? $sf_user->getAttribute($modulo.'_noworganismos') : '';
      
		  $roles = UsuarioRol::getRepository()->getRolesByUser($sf_user->getAttribute('userId'),1);
          if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles))
          {
          	$user = $sf_user->getAttribute('userId');
          	$arrayOrganismo = $subcategoria? OrganismoTable::doSelectByOrganismoa($subcategoria, $user) : OrganismoTable::getAllOrganismos();
          }
          else 
          {
          	$user='';
          	$arrayOrganismo = $subcategoria? OrganismoTable::doSelectByOrganismoa($subcategoria, $user) : '';
          }
			$arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($categoria);
			$arrayDocumentacion = $organismo ?DocumentacionOrganismoTable::doSelectByOrganismo($organismo) : '';
			$subcategoria_organismos_selected = $sf_user->getAttribute($modulo.'_nowsubcategoria');
			$organismos_selected = $sf_user->getAttribute($modulo.'_noworganismos');
			$documentacion_selected = $sf_user->getAttribute($modulo.'_nowdocumentacion');
?>
<link type="text/css" rel="stylesheet" href="/js/calendario/dhtml_calendar.css" media="screen"></link>
<script language="javascript" type="text/javascript" src="/js/calendario/dhtml_calendar.js"></script>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>

<div class="mapa"><strong>Organismos</strong><?php if($documentacion !=''):?> > Documentacion: <?php echo $documentacion->getNombre(); endif;?> > Archivos</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Archivos de <?php if($documentacion !=''):?>Documentacion: <?php echo $documentacion->getNombre(); else: ?>Organismos<?php endif;?></h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'ArchivoDO'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
        <?php  include_component('miembros_organismo','MenuOrganismos',array('id' => $organismoBsq,'modulo'=>$modulo));    ?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $redireccionGrupo) ?></div>
			<?php endif; ?>
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s <?php if ($cajaBsq) echo " con la palabra '".$cajaBsq."'" ?> </span> 
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('archivos_d_o/nueva?'.$redireccionGrupo) ?>';" style="float: right;" value="Nuevo Archivo" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('archivos_d_o/delete?'.$redireccionGrupo) ?>">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<?php if(validate_action('baja')):?>
					<th width="5%">&nbsp;</th>
					<?php endif;?>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('archivos_d_o/index?sort=fecha&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Fecha</a>
					</th>
					<th width="35%">
						<a href="<?php echo url_for('archivos_d_o/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Titulo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('archivos_d_o/index?sort=organismo_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Organismo</a>
					</th>
					<th width="15%">
						<a href="<?php echo url_for('archivos_d_o/index?sort=owner_id&type='.$sortType.'&page='.$paginaActual.'&orden=1&'.$redireccionGrupo) ?>">Creado por</a>
					</th>
					<th width="5%">&nbsp;</th>
					<th width="5%">&nbsp;</th>
				</tr>
				<?php $i=0; foreach ($archivo_do_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<?php if(validate_action('baja')):?>
					<td><input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" /></td>
					<?php endif;?>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getFecha())) ?>
					</td>
					<td valign="center">
					<?php if(validate_action('listar')):?>
						<a href="<?php echo url_for('archivos_d_o/show?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
							<strong><?php echo $valor->getNombre() ?></strong>
						</a>
					<?php endif;?>	
					</td>
					<td valign="center" align="left">
					    <?php if($valor->getOrganismoId()):?>
					    <?php $Organismo = Organismo::getRepository()->findOneById($valor->getOrganismoId())?>
						<?php echo $Organismo->getNombre() ?>
						<?php endif;?>
					</td>
					<td valign="center" align="left">
					    <?php if($valor->getOwnerId()):?>
					    <?php $usuario = Usuario::getRepository()->findOneById($valor->getOwnerId())?>
						<?php echo $usuario->getApellido().', '.$usuario->getNombre() ?>
						<?php endif;?>
					</td>
					<td valign="center" align="center">
					<?php if(validate_action('modificar') || $valor->getOwnerId() == $sf_user->getAttribute('userId')):?>
						<a href="<?php echo url_for('archivos_d_o/editar?id='.$valor->getId().'&'.$redireccionGrupo) ?>">
							<?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?>
						</a>
						<?php endif;?>
					</td>
		          <td valign="center" align="center">
		          <?php if(validate_action('baja') || $valor->getOwnerId() == $sf_user->getAttribute('userId')):?>
		          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'archivos_d_o/delete?id='.$valor->getId().'&'.$redireccionGrupoEdit, array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
		          <?php endif;?>	
		          </td>
				</tr>
				<?php endforeach; ?>
				<?php if(validate_action('baja')):?>
				<tr>
					<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
					<td colspan="5"><input type="submit" class="boton" value="Borrar seleccionados" onclick="return confirm('Confirma la eliminaci&oacute;n de los registros seleccionados?');"/></td>
				</tr>
				<?php endif;?>
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
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType, $redireccionGrupo) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
			
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('archivos_d_o/nueva?'.$redireccionGrupo) ?>';" style="float: right;" value="Nuevo Archivo" name="newNews" class="boton"/>
			<?php endif;?>

			
		</div>
		<?php endif; ?>
		<?php if($documentacionBsq && validate_action('listar','documentacion_organismos') && $organismoBsq): ?>
                   <?php $redireccion = $documentacionBsq?'?documentacion_organismo[organismo_id]='.$organismoBsq : ''; ?>
		  <input type="button" onclick="javascript:location.href='<?php echo url_for('documentacion_organismos/index'.$redireccion) ?>';"  value="Volver a la Documentacion" name="newNews" class="boton"/>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('archivos_d_o/index?'.$redireccionGrupo) ?>">
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
		   echo include_component('categoria_organismos','listacategoria',array('name'=>'archivo_d_o'));
		?>
		</td>
		</tr>
		<tr>
			<td><label> Subcategoría </label></td>
			<td valign="middle">
			<span id="content_subcategoria">
			<?php 
			// llamo al partial que se encuentra subcategoria _ organismos/selectByCategoriaOrganismo para que luego lo reescriba el componente del modulo  categoria _ organismos
			include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected, 'name'=>'archivo_d_o')); 
			?>
			</span>
			</td>
		</tr>
        <tr>
          <td><label>Organismo </label></td>
          <td valign="middle">
          <span id="content_organismos">              
          	<?php 
          	// llamo al partial que se encuentra organismos/listByOrganismos para que luego lo reescriba el componente del modulo  subcategoria _ organismos
          	include_partial('organismos/listByOrganismos', array ('arrayOrganismo'=>$arrayOrganismo, 'organismos_selected'=>$organismos_selected, 'name'=>'archivo_d_o'))?>
          </span>    
          </td>
        </tr>

        <tr>
          <td><label>Documentacion </label></td>
          <td valign="middle">
          	<span id="content_documentacion"> 
			<?php include_partial('documentacion_organismos/selectByOrganismo', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$documentacion_selected, 'name'=>'archivo_d_o')) ?>
			</span>       
          </td>
        </tr> 
		 <tr>
					<td width="29%"><label>Fecha Desde:</label></td>
					<td width="71%" valign="middle">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="desde_busqueda" id="desde_busqueda" value="<?php echo $sf_user->getAttribute('archivos_d_o_nowdesde');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('desde_busqueda', this);"/>
					</td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label>Fecha Hasta:</label></td>
					<td style="padding-top: 5px;">
						<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:80px;" name="hasta_busqueda" id="hasta_busqueda" value="<?php echo $sf_user->getAttribute('archivos_d_o_nowhasta');?>" class="form_input"/>
						<img border="0" style="margin-bottom: -3px;" src="/images/calendario.gif" class="clickeable" onclick="displayCalendar('hasta_busqueda', this);"/>
					</td>
				</tr>
       <tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>	
						</td>
						<td>
							<?php if ($cajaBsq || $categoriaBsq || $subcategoriaBsq || $organismoBsq || $documentacionBsq || $desdeBsq || $hastaBsq): ?>
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

