<?php
	use_helper('Javascript');
	use_helper('Security');

	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form->renderGlobalErrors();
	echo $form['accion_alta']->renderError();
	echo $form['accion_baja']->renderError();
	echo $form['accion_modificar']->renderError();
	echo $form['accion_listar']->renderError();
	echo $form['accion_publicar']->renderError();
	echo $form['aplicacion_id']->renderError();
	echo $form['rol_id']->renderError();
?>
<form action="<?php echo url_for('aplicaciones_rol/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
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
		<legend>Aplicaciones por Rol</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="8%"><?php echo $form['rol_id']->renderLabel() ?></td>
					<td width="92%" valign="middle"><?php echo $form['rol_id'] ?></td>
				</tr>
				<tr>
					<td><?php echo $form['aplicacion_id']->renderLabel() ?></td>
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
	<?php if(validate_action('alta') || validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php endif; ?>	
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('aplicaciones_rol/index?page='.$pageActual) ?>';"/>
	</div>
</form>