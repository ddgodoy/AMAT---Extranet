<?php
	use_helper('Security');
	use_helper('Object');
	use_helper('Javascript');
?>
<div class="mapa"><strong>Administracion del Menu</strong> </div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Administracion del Menu</h1></td>
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
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s </span> 
			<?php if (validate_action('alta')): ?>
				<input type="button" onclick="javascript:location.href='<?php echo url_for('menu/nueva') ?>';" style="float: right;" value="Nuevo grupo" name="newNews" class="boton"/>
			<?php endif;?>
		</div>
		<?php if ($cantidadRegistros > 0): ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="8%">Posici&oacute;n</th>
					<th width="25%">Grupos</th>
					<th width="25%">Elemento</th>
					<th width="25%">Subelementos</th>
					<th width="5%"></th>
					<th width="4%"></th>
					<th width="4%"></th>
					<th width="4%"></th>
				</tr>
		    <?php
		    	$url_upd_posicion = url_for('menu/updatePosicion').'?id=';

					foreach ($menu_list as $menu):
		     		if (!$menu->getPadreId()):
		    ?>
						<tr style="background-color:#EEEEEE;">
							<td><?php echo $menu->getPosicion() ?></td>
							<td><span <?php if ($menu->getHabilitado() != 1): ?>style="text-decoration:line-through;color:#999;"<?php endif;?>><?php echo $menu->getNombre() ?></span></td>
							<td></td>
							<td></td>
							<td>
								<a href="<?php echo $url_upd_posicion.$menu->getId().'&dir=up&dad='.$menu->getPadreId() ?>"><img src="/images/arriba.gif" border="0"/></a>
								<a href="<?php echo $url_upd_posicion.$menu->getId().'&dir=down&dad='.$menu->getPadreId() ?>"><img src="/images/abajo.gif" border="0"/></a>
							</td>
							<td valign="top">
							<?php if (validate_action('alta')): ?>
								<a href="<?php echo url_for('menu/nueva?padreid=' . $menu->getId()) ?>"><?php echo image_tag('listado.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Agregar elementos')) ?></a>
							<?php endif;?>
							</td>
							<td valign="top">
						  <?php if (validate_action('modificar')): ?>
						  	<a href="<?php echo url_for('menu/editar?id=' . $menu->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?></a>
						  <?php endif;?>
						  </td>
						  <td valign="top">
						  <?php
						  	if (validate_action('baja')) {
						  		echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'menu/delete?id='.$menu->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la menu ' . $menu->getNombre() . '?'));
						  	}
						  ?>
					    </td>
						</tr>
					 <?php
					 	foreach ($menu_list AS $menuHijo):
					 		if ($menuHijo->getPadreId() && $menuHijo->getPadreId() == $menu->getId()):
					 ?>
						<tr>
							<td><?php echo $menuHijo->getPosicion()?></td>
							<td></td>
							<td><span <?php if ($menu->getHabilitado()!=1 || $menuHijo->getHabilitado()!=1): ?>style="text-decoration:line-through;color:#999;"<?php endif;?>><?php echo $menuHijo->getNombre() ?></span></td>
							<td></td>
							<td>
								<a href="<?php echo $url_upd_posicion.$menuHijo->getId().'&dir=up&dad='.$menuHijo->getPadreId() ?>"><img src="/images/arriba.gif" border="0"/></a>
								<a href="<?php echo $url_upd_posicion.$menuHijo->getId().'&dir=down&dad='.$menuHijo->getPadreId() ?>"><img src="/images/abajo.gif" border="0"/></a>
							</td>
							<td valign="top">
						  <?php if (validate_action('alta')): ?>
						  	<a href="<?php echo url_for('menu/nueva?padreid=' . $menuHijo->getId()) ?>"><?php echo image_tag('listado.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Agregar elementos')) ?></a>
						  <?php endif;?>
						  </td>
				      <td valign="top">
						  <?php if (validate_action('modificar')): ?>
						  	<a href="<?php echo url_for('menu/editar?id=' . $menuHijo->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?></a>
						  <?php endif;?>
						  </td>
						  <td valign="top">
						  <?php
						  	if (validate_action('baja')) {
						  		echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'menu/delete?id='.$menuHijo->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la menu ' . $menuHijo->getNombre() . '?'));
						  	}
						  ?>
					    </td>
						</tr>
           <?php
           	foreach ($menu_list AS $menuNieto):
           		if ($menuNieto->getPadreId() && $menuNieto->getPadreId() == $menuHijo->getId()):
           ?>
						<tr>
							<td><?php echo $menuNieto->getPosicion()?></td>
							<td></td>
							<td></td>
							<td><span <?php if ($menu->getHabilitado()!=1 || $menuHijo->getHabilitado()!=1 || $menuNieto->getHabilitado()!=1 ): ?>style="text-decoration:line-through;color:#999;"<?php endif;?>><?php echo $menuNieto->getNombre() ?></span></td>
							<td>
								<a href="<?php echo $url_upd_posicion.$menuNieto->getId().'&dir=up&dad='.$menuNieto->getPadreId() ?>"><img src="/images/arriba.gif" border="0"/></a>
								<a href="<?php echo $url_upd_posicion.$menuNieto->getId().'&dir=down&dad='.$menuNieto->getPadreId() ?>"><img src="/images/abajo.gif" border="0"/></a>
							</td>
							<td></td>
							<td valign="top">
						  <?php if (validate_action('modificar')): ?>
						  	<a href="<?php echo url_for('menu/editar?id=' . $menuNieto->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Editar')) ?></a>
						  <?php endif;?>
						  </td>
						  <td valign="top">
						  <?php
						  	if (validate_action('baja')) {
						  		echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'menu/delete?id='.$menuNieto->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la menu ' . $menuNieto->getNombre() . '?'));
						  	}
						  ?>
					    </td>
						</tr>
						<?php endif; ?>
					<?php endforeach; ?>

				<?php endif; ?>
			<?php endforeach; ?>
			<tr><td><br /></td></tr>

			<?php endif; ?>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay registros cargados</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
			<div class="lineaListados"><span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span></div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('menu/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td>Grupos</td>
						<td>
							<?php echo select_tag('caja_busqueda',options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects(MenuTable::getGrupo()), $sf_user->getAttribute('menu_nowcaja')),array('style'=>'width:200px;','class'=>'form_input'));?>
							<?php echo observe_field('caja_busqueda', array('update'=>'elentosid','url'=>'menu/listElementos','with'=>"'id_grupo='+value",'script'=> true));?>
						</td>
					</tr>
					<tr>
						<td>Elementos</td>
						<td><div id="elentosid"><?php echo include_component('menu','listarElementos')?></div></td>
					</tr>
					<tr>
						<td>SubElementos</td>
						<td><div id="subelemetos"><?php echo include_component('menu','listarSubElementos')?></div></td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
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