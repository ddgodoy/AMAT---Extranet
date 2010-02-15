<?php use_helper('TestPager') ?>
<?php use_helper('Security','Object') ?>

<div class="mapa"><strong>Administraci&oacute;n</strong> > Organismos > Miembros</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Miembros de Organismos</h1></td>
				<td width="5%" align="center"><?php $nombretabla = 'UsuarioOrganismo'; echo link_to(image_tag('export_exel.jpg', array('title' => 'Exportar exel', 'alt' => 'Exportar exel', 'border' => '0')), 'inicio/exportar?tabla='.$nombretabla.'&filtro='.$sf_context->getModuleName().'_nowfilter&tipo=.xls'); ?></td>
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

	<?php  include_partial('MenuOrganismos',array('Organismos' => $Organismos, 'modulo'=>$modulo))?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
		     <strong class="subtitulo" style="float:left; margin-right:10px; width:auto;">Miembros del Organismos</strong>
       		<?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
	  	    <?php endif; ?>	 <!--<span class="info" style="float: left;">Hay 1 Miembro/s </span>-->
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
					<th width="15%" style="text-align:left;">
						<a href="<?php echo url_for('miembros_organismo/index?sort=u.apellido&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Apellidos</a>
					</th>
					<th width="15%" style="text-align:left;">
						<a href="#">Nombre</a>
					</th>					
					<th width="10%">
						<a href="#">Mutua</a>
					</th>
					<th width="30%">
						<a href="#">Email</a>
					</th>
					<th width="15%">
						<a href="#">Teléfono</a>
					</th>
					<th width="30%">
						<a href="#">Grupo de trabajo</a>
					</th>
				</tr>
				
				<?php $i=0; foreach ($usuario_list as $usuario): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
					<td><a><strong><?php echo $usuario->Usuario->getApellido() ?></strong></a></td>					
					<td><a><strong><?php echo $usuario->Usuario->getNombre() ?></strong></a></td>					
					<td><?php echo $usuario->Usuario->getMutua() ?></td>
					<td><?php echo $usuario->Usuario->getEmail() ?></td>
					<td><?php echo $usuario->Usuario->getTelefono() ?></td>
					<td><?php echo $usuario->Organismo->getNombre() ?></td>
							        
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php else : ?>
			<?php if ($cajaBsq != '') : ?>
				<div class="mensajeSistema error">Su b&uacute;squeda no devolvi&oacute; resultados</div>
			<?php else : ?>
				<div class="mensajeSistema comun">No hay Usuarios en el grupo</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($cantidadRegistros > 0) : ?>
		<div class="lineaListados">	
		    <?php if($pager->haveToPaginate()): ?>
			<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
		    <?php endif; ?>	
			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> miembro/s</span>		
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar por Nombre &oacute; Usuario</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('miembros_organismo/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					   <td width="20%">
					    Nombre &oacute; Usuario
					   </td>
						<td width="80%">
							<input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					   <td width="20%">
					   Organismos
					   </td>
						<td width="80%">
							<?php echo select_tag('organismo',options_for_select(array('0'=>'--Seleccionar--')+_get_options_from_objects(OrganismoTable::getAllOrganismos()),$organismosBsq))?> 
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
							<?php if ($cajaBsq || $organismosBsq): ?>
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