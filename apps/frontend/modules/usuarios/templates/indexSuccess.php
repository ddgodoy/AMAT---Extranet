<?php
	use_helper('TestPager');
	use_helper('Security','Object');
?>
<script type="text/javascript" src="/js/common_functions.js"></script>

<div class="mapa"><strong>Administraci&oacute;n</strong> &gt Gesti&oacute;n de Usuarios</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Gesti&oacute;n de Usuarios</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'Usuario'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('usuarios/nuevo') ?>';" style="float: right;" value="Crear Nuevo Usuario" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="<?php echo url_for('usuarios/delete') ?>">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados" >
			<tbody>
				<tr>
					<th>&nbsp;</th>
				  <th width="30%" style="text-align:left;">
						<a href="<?php echo url_for('usuarios/index?sort=apellido&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Apellido</a>,
						<a href="<?php echo url_for('usuarios/index?sort=nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Nombre</a>
					</th>
					<th width="30%">
						<a href="<?php echo url_for('usuarios/index?sort=login&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Usuario</a>
					</th>
					<th width="30%">
						<a href="<?php echo url_for('usuarios/index?sort=mutua_id&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Mutua</a>
					</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
                                        </tr>
                                        <?php $i=0; foreach ($usuario_list as $value): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
                                        <tr class="<?php echo $odd ?>">
					<td><input type="checkbox" name="id[]" value="<?php echo $value->getId() ?>" /></td>
					<td>
						<a href="<?php echo url_for('usuarios/editar?id='.$value->getId()) ?>">
							<strong><?php echo $value->getApellido() ?>, <?php echo $value->getNombre() ?></strong>
						</a>
					</td>
					<td><?php echo $value->getLogin() ?></td>
					<td><?php echo $value->getMutua() ?></td>
					<td>
					<?php if(validate_action('listar','aplicaciones_rol')):?>
						<a href="<?php echo url_for('aplicaciones_rol/listausuario?id='.$value->getId()) ?>">
							<?php echo image_tag('ver_perfiles.png', array('title' => 'Perfiles', 'alt' => 'Editar', 'width' => '17', 'height' => '20', 'border' => '0')) ?>
						</a>
					<?php endif;?>	
					</td>
					<td>
					<?php if(validate_action('modificar')):?>
						<a href="<?php echo url_for('usuarios/editar?id='.$value->getId()) ?>">
							<?php echo image_tag('edit.png', array('title' => 'Editar', 'alt' => 'Editar', 'width' => '17', 'height' => '20', 'border' => '0')) ?>
						</a>
					<?php endif;?>	
					</td>
					<td>
					<?php if(validate_action('baja')):?>
					<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'usuarios/delete?id='.$value->getId(), array('method' => 'delete', 'confirm' => 'Confirma la eliminaci&oacute;n del registro?')) ?>
					<?php endif;?>
					</td>			        
				</tr>
				<?php endforeach; ?>
				<tr>
					<td><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
					<td colspan="6"><input type="submit" class="boton" value="Borrar seleccionados" onclick="return confirm('Confirma la eliminaci&oacute;n de los registros seleccionados?');"/></td>
				</tr>
			</tbody>
		</table>
		</form>
		<?php else : ?>
			<?php if ($cajaNomBsq || $cajaApeBsq || $cajaMuBsq || $cajaGruBsq || $cajaConBsq || $cajaRolBsq || $cajaRolBsq ) : ?>
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
			<?php if(validate_action('alta')):?>
			<input type="button" onclick="javascript:location.href='<?php echo url_for('usuarios/nuevo') ?>';" style="float:right;margin-top:10px;" value="Crear Nuevo Usuario" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre &oacute; Usuario</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('usuarios/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="20%">Nombre</td>
					<td width="80%">
					<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda_nombre" class="form_input" value="<?php echo $cajaNomBsq ?>"/>
					</td>
					</tr>
					<tr>
					<td width="20%">Apellido</td>
					<td width="80%">
					<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda_apellido" class="form_input" value="<?php echo $cajaApeBsq ?>"/>
					</td>
					</tr>
                                        <tr>
					<td width="20%">Usuario</td>
					<td width="80%">
					<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda_usuario" class="form_input" value="<?php echo $cajaUsuBsq ?>"/>
					</td>
					</tr>
                                        <tr>
					<td width="20%">Activo</td>
					<td width="80%"><?php echo checkbox_tag('activoBsq', '1', $activoBsq) ?></td>
					</tr>
					<tr>
					<td width="20%">Perfil</td>
					<td width="80%">
					 <?php echo select_tag('cajaRolBsq',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(Rol::getRepository()->getAllRol()),$cajaRolBsq),array('style'=>'width:200px'));?>	
					</td>
					</tr>
         		                <tr>
					<td width="20%">Mutua</td>
					<td width="80%">
					 <?php echo select_tag('mutuas',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(MutuaTable::getAllMutuas()),$cajaMuBsq),array('style'=>'width:200px'));?>	
					</td>
					</tr>
					<tr>
					<td width="20%">Grupo de trabajo</td>
					<td width="80%">
					 <?php echo select_tag('grupo',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(GrupoTrabajoTable::getAllGrupoTrabajo()),$cajaGruBsq),array('style'=>'width:200px'));?>	
					</td>
					</tr>
					<tr>
					<td width="20%">Consejo territorial</td>
					<td width="80%">
					<?php echo select_tag('consejo',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(ConsejoTerritorialTable::getAllconsejo()),$cajaConBsq),array('style'=>'width:200px'));?>	
					</td>
					</tr>
					<tr>
					<td style="padding-top:5px;">
					<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
					</td>
					<td style="padding-top:5px;">
					<?php if ($cajaNomBsq || $cajaApeBsq || $cajaMuBsq || $cajaGruBsq || $cajaConBsq || $activoBsq || $cajaRolBsq || $cajaUsuBsq ): ?>
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