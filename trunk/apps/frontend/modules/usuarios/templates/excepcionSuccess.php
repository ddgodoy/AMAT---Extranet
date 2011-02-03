<?php
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);

	use_javascript('/sfFormExtraPlugin/js/double_list.js');
	use_helper('Security');
?>
<div class="mapa">
	<strong>Administraci&oacute;n </strong>&gt; 
        <a href="<?php echo url_for('usuarios/index') ?>">Gesti&oacute;n de Usuarios</a> &gt; Actualizar Usuario &gt; Nueva Excepci&oacute;n
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Nueva Excepción para <strong><?php echo $usuario->getApellido() ?>, <?php echo $usuario->getNombre() ?></strong></h1></td>
		<td width="5%" align="right">
			<a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a>
		</td>
	</tr>
</table>
<?php if($aplication_error!=''): ?>
    <ul class="error_list">
        <li><?php echo $aplication_error?></li>
    </ul>
<?php endif; ?>
<form action="<?php echo url_for('usuarios/excepcion?usuario='.$usuario->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>
        <?php if($sf_request->hasParameter('excepcion')): ?>
                <input type="hidden" name="excepcion" value="<?php echo $sf_request->getParameter('excepcion') ?>" />
        <?php endif; ?>

	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="48%"><label>Los campos marcados con (*) son obligatorios</label></td>
				<td width="52%" align="right"> </td>
			</tr>
		</tbody>
	</table>

	<br />
	<fieldset>
		<legend>Excepción</legend>
                <?php if ($form->getObject()->isNew()): ?>
                 <input type="hidden" id="aplicacion_rol_rol_id" name="aplicacion_rol[name]" value="aplication_<?php echo $usuario->getId()?>" class="form_input" style="width: 330px;">
                <?php else: ?>
                 <input type="hidden" id="aplicacion_rol_rol_id" name="aplicacion_rol[rol_id]" value="<?php echo $form['rol_id']->getValue()?>" class="form_input" style="width: 330px;">
                 <input type="hidden" id="aplicacion_rol_id" name="id" value="<?php echo $sf_request->getParameter('id')?>" class="form_input" style="width: 330px;">
                <?php endif; ?>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
                                    <td style=" width: 80px;"><?php echo $form['aplicacion_id']->renderLabel() ?></td>
					<td valign="middle"><?php echo $form['aplicacion_id'] ?></td>
				</tr>
				<tr>
					<td colspan="2"><br />
						<table cellpadding="3" cellspacing="3" style="border:1px solid #EEEEEE;">
							<tr bgcolor="#EEEEEE">
								<td colspan="5" align="center"><label>ACCIONES</label></td>
							</tr>
							<tr>
								<td width="80" style="text-align:center;"><?php echo $form['accion_alta']->renderLabel() ?></td>
								<td width="80" style="text-align:center;"><?php echo $form['accion_baja']->renderLabel() ?></td>
								<td width="80" style="text-align:center;"><?php echo $form['accion_modificar']->renderLabel() ?></td>
								<td width="80" style="text-align:center;"><?php echo $form['accion_listar']->renderLabel() ?></td>
								<td width="80" style="text-align:center;"><?php echo $form['accion_publicar']->renderLabel() ?></td>
							</tr>
							<tr>
								<td align="center"><?php echo $form['accion_alta'] ?></td>
								<td align="center"><?php echo $form['accion_baja'] ?></td>
								<td align="center"><?php echo $form['accion_modificar'] ?></td>
								<td align="center"><?php echo $form['accion_listar'] ?></td>
								<td align="center"><?php echo $form['accion_publicar'] ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>

	<div class="botonera" style="padding-top:10px;">
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('usuarios/editar?id='.$usuario->getId()) ?>';"/>
	</div>
</form>