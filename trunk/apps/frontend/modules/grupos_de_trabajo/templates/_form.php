<?php
	use_helper('Javascript');
	use_helper('Security');

	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form['nombre']->renderError();
	echo $form['detalle']->renderError();
?>
<form action="<?php echo url_for('grupos_de_trabajo/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
		<legend>Grupo de Trabajo</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><?php echo $form['nombre']->renderLabel() ?></td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td valign="top"><label>Descripci&oacute;n *</label></td>
					<td valign="middle"><?php echo $form['detalle'] ?></td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
	<?php if(validate_action('alta') || validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action" />
	<?php endif;?>
		<input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('grupos_de_trabajo/index?page='.$pageActual) ?>';"/>
	</div>
</form>