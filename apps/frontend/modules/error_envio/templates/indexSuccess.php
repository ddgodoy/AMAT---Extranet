<?php use_helper('Text') ?>
<?php use_helper('TestPager') ?>
<?php use_helper('Security') ?>
<script language="javascript" type="text/javascript" src="/js/common_functions.js"></script>
<script language="javascript" type="text/javascript">
	function setActionFormList(accion)
	{
		var parcialMensaje = '';
		var rutaToPub = '<?php echo url_for('error_envio/enviar') ?>';
		var rutaToDel = '<?php echo url_for('error_envio/delete') ?>';
		var objectFrm = $('frmListDocOrganismos');

		if (accion == 'enviar') {
			objectFrm.action = rutaToPub;
			parcialMensaje = 'envio';
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


<div class="mapa"><strong>Comunicados</strong> > Error Envio de Comunicados</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Error Envio de comunicados</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema error"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>

	<div class="leftside">
		<div class="lineaListados">
			<?php if($pager->haveToPaginate()): ?>
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s <?php if ($cajaBsq) echo " con la palabra '".$cajaBsq."'" ?> </span> 
		</div>
		<?php if ($cantidadRegistros > 0) : ?>
		<form method="post" enctype="multipart/form-data" action="" id="frmListDocOrganismos">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
			<tbody>
				<tr>
				    <?php if(validate_action('baja') || validate_action('modificar')): ?>
				    <th width="5%">
					</th>
					<?php endif; ?>
					<th width="10%" style="text-align:left;">
						<a href="<?php echo url_for('error_envio/index?sort=er.created_at&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Fecha</a>
					</th>
					<th width="20%">
						<a href="<?php echo url_for('error_envio/index?sort=c.nombre&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Comunicado</a>
					</th>
					<th width="20%">
						<a href="<?php echo url_for('error_envio/index?sort=u.email&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Email</a>
					</th>
					<th width="20%">
						<a href="<?php echo url_for('error_envio/index?sort=er.error&type='.$sortType.'&page='.$paginaActual.'&orden=1') ?>">Error</a>
					</th>
					<th width="5%">&nbsp;</th>
				</tr>
				
				<?php  $i=0; foreach ($envio_error_list as $valor): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
				<tr class="<?php echo $odd ?>">
				    <?php if(validate_action('baja') || validate_action('modificar')): ?>
				    <td width="5%">
					<input type="checkbox" name="id[]" value="<?php echo $valor->getId() ?>" />
					</td>
					<?php endif; ?>
					<td valign="center" align="left">
						<?php echo date("d/m/Y", strtotime($valor->getCreatedAt())) ?>
					</td>
					<td valign="center">					
							<strong><?php echo $valor->EnvioComunicado->Comunicado->getNombre() ?></strong>
					</td>
					<td valign="center">					
						<a href="<?php echo url_for('usuarios/editar?id='.$valor->getUsuarioId()) ?>"><?php echo $valor->Usuario->getEmail() ?></a>					
					</td>
					<td valign="center">					
						<a href="<?php echo url_for('error_envio/show?id='.$valor->getId()) ?>" ><?php echo truncate_text($valor->getError(),50,'...') ?></a>					
					</td>
		          	<td valign="center" align="center">
		          	<?php if(validate_action('baja')):?>
		          	<?php echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')), 'error_envio/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
		          	<?php endif;?>	
		          	</td>
				</tr>
				<?php endforeach; ?>
				<?php if(validate_action('baja') || validate_action('modificar')):?>
				<tr class="gris">
                                    <td width="3%"><input type="checkbox" id="check_todos" name="check_todos" onclick="checkAll(document.getElementsByName('id[]'));"/></td>
				<td>
				<input type="submit" class="boton" value="Enviar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('enviar');" />
				</td>
				<td colspan="4">
				<input type="submit" class="boton" value="Borrar seleccionados" name="btn_delete_selected" onclick="return setActionFormList('eliminar');" />
				</td>
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
				<div style="float:left;" class="paginado"><?php echo test_pager($pager, $orderBy, $sortType) ?></div>
			<?php endif; ?>

			<span class="info" style="float: left;">Hay <?php echo $cantidadRegistros ?> Registro/s</span>
			
		</div>
		<?php endif; ?>
	</div>
<!-- * -->
	<div class="rightside">
		<div class="paneles">
			<h1>Buscar</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo url_for('error_envio/index') ?>">
			<table width="100%" cellspacing="4" cellpadding="0" border="0">
				<tbody>
					<tr>
					<td width="30%">Comunicado</td>
						<td>
						 <input type="text" onblur="this.style.background='#E1F3F7'" onfocus="this.style.background='#D5F7FF'" style="width:97%;" name="caja_busqueda" class="form_input" value="<?php echo $cajaBsq ?>"/>
						</td>
					</tr>
					<tr>
					<tr>
						<td style="padding-top:5px;">
							<span class="botonera"><input type="submit" class="boton" value="Buscar" name="btn_buscar"/></span>							
						</td>
						<td style="padding-top:5px;">
						<?php if ($cajaBsq): ?>
							<span class="botonera"><input type="submit" class="boton" value="Limpiar" name="btn_quitar"/></span>
							<?php endif;?>
						</td>
					</tr>

				</tbody>
			</table>
			</form>
		</div>
	</div>
<!-- * -->
<div class="clear"></div>
















<!--<h1>Error envio List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Envio</th>
      <th>Usuario</th>
      <th>Error</th>
      <th>Estado</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Deleted</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($envio_error_list as $envio_error): ?>
    <tr>
      <td><a href="<?php echo url_for('error_envio/edit?id='.$envio_error->getId()) ?>"><?php echo $envio_error->getId() ?></a></td>
      <td><?php echo $envio_error->getEnvioId() ?></td>
      <td><?php echo $envio_error->getUsuarioId() ?></td>
      <td><?php echo $envio_error->getError() ?></td>
      <td><?php echo $envio_error->getEstado() ?></td>
      <td><?php echo $envio_error->getCreatedAt() ?></td>
      <td><?php echo $envio_error->getUpdatedAt() ?></td>
      <td><?php echo $envio_error->getDeleted() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('error_envio/new') ?>">New</a>
-->