<?php
	use_helper('Javascript');
	use_helper('Security'); 
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);

	echo $form['usuario_id']->renderError();
	echo $form['aplicacion_externa_id']->renderError();
	echo $form['login']->renderError();
?>
<form action="<?php echo url_for('aplicaciones_externas_usuario/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?uid='.$form->getObject()->getUsuarioId().'&aeid='.$form->getObject()->getAplicacionExternaId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>

	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="48%"><label>Ingrese el login que lo identifica en la aplicación externa</label></td>
				<td width="52%" align="right"> </td>
			</tr>
		</tbody>
	</table>
	<br />
	<fieldset>
		<legend>Datos de Login de la Aplicación Externa del Usuario</legend>
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr>
				<td width="45%">
					<table cellspacing="4" cellpadding="0" border="0">
						<tbody>							
							<tr>
								<td><?php echo $form['login']->renderLabel() ?></td>
								<td valign="middle"><?php echo $form['login'] ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('aplicaciones_externas_usuario/index?page='.$pageActual) ?>';"/>
	</div>
</form>