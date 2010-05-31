<?php
	use_helper('Javascript');
	use_helper('Security');

	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form->renderGlobalErrors();
	//echo $form['email']->renderError();
?>
<script>
function desmarcar1()
{
	document.getElementById("categoria_asunto_activo_2").checked = false;
}
function desmarcar2()
{
	document.getElementById("categoria_asunto_activo_1").checked = false;
}

</script>

<form action="<?php echo url_for('categoria_asunto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
		<legend>Email de Contacto</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="15%"><?php echo $form['nombre']->renderLabel() ?></td>
					<td width="23%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td><label><?php echo $form['email_1']->renderLabel('Cuenta de Correo 1') ?></label></td>
					<td valign="middle"><?php echo $form['email_1'] ?></td>
					<td align="left" valign="middle"  style="font-size:11px;"><?php echo $form['activo_1'] ?>&nbsp;&nbsp;Activado</td>
				</tr>
				<tr>
					<td><label><?php echo $form['email_2']->renderLabel('Cuenta de Correo 2') ?></label></td>
					<td valign="middle"><?php echo $form['email_2'] ?></td>
					<td valign="middle" style="font-size:11px;"><?php echo $form['activo_2'] ?>&nbsp;&nbsp;Activado</td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
	<?php if(validate_action('alta')|| validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php endif;?>	
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('categoria_asunto/index?page='.$pageActual) ?>';"/>
	</div>
</form>