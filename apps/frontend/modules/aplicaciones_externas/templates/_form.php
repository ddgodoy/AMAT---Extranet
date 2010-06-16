<?php
	use_helper('Javascript');
	use_helper('Security'); 
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);

	echo $form['nombre']->renderError();
	echo $form['url']->renderError();
	echo $form['imagen']->renderError();
?>
<form action="<?php echo url_for('aplicaciones_externas/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
		<legend>Aplicaciones Externas</legend>
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr>
				<td width="45%">
					<table cellspacing="4" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td width="80"><?php echo $form['nombre']->renderLabel() ?></td>
								<td valign="middle"><?php echo $form['nombre'] ?></td>
							</tr>
							<tr>
								<td><?php echo $form['url']->renderLabel() ?></td>
								<td valign="middle"><?php echo $form['url'] ?></td>
							</tr>
							<tr>
								<td><?php echo $form['imagen']->renderLabel() ?></td>
								<td valign="middle"><?php echo $form['imagen'] ?><label style="padding-left:10px;">150px * 52px</label></td>
							</tr>
							<tr>
								<td valign="top"><label><?php echo $form['detalle']->renderLabel() ?></label></td>
								<td valign="middle"><?php echo $form['detalle'] ?></td>
							</tr>
                                                        <tr>
								<td valign="top"><label><?php echo $form['requiere']->renderLabel('Requiere usuarios y contraseña') ?></label></td>
								<td valign="middle"><?php echo $form['requiere'] ?></td>
							</tr>
						</tbody>
					</table>
				</td>
				<td width="55%" valign="top">
					<?php if($form->getObject()->getImagen()): ?>
						<img src="<?php echo public_path('uploads/aplicaciones_externas/'.$form->getObject()->getImagen()) ?>"/>
						<div style="margin-top:10px;">
							<?php echo checkbox_tag('borrar_imagen', '1',false,array('style'=>'vertical-align:middle;')) ?>
							<label style="padding-left:5px;">Marcar para borrar</label>
						</div>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('aplicaciones_externas/index?page='.$pageActual) ?>';"/>
	</div>
</form>