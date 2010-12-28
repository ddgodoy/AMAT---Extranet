<?php
	use_helper('Javascript');
	use_helper('Security');

	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);

	echo $form->renderGlobalErrors();
	echo $form['nombre']->renderError();
	echo $form['titulo']->renderError();
	echo $form['descripcion']->renderError();
?>
<script type="text/javascript">
function setFrmValorEstado(estado)
{
	document.getElementById('hid_valor_estado').value = estado;
	document.getElementById('frmContenido').submit();
}
</script>
<form id="frmContenido" action="<?php echo url_for('contenidos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?><input type="hidden" name="sf_method" value="put" /><?php endif; ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="48%"><label>Los campos marcados con (*) son obligatorios</label></td>
				<td width="52%" align="right"><?php if (!$form->getObject()->isNew()) { echo 'Estado: '.$form->getObject()->getEstado(); } ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<fieldset>
		<legend>Contenidos</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><?php echo $form['nombre']->renderLabel('* Nombre') ?></td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td valign="top"><label><?php echo $form['titulo']->renderLabel('* T&iacute;tulo') ?></label></td>
					<td valign="middle"><?php echo $form['titulo'] ?></td>
				</tr>
				<tr>
					<td style="padding-top: 5px;"><label><?php echo $form['descripcion']->renderLabel('* Contenido') ?></label></td>
					<td valign="middle"><?php echo $form['descripcion'] ?></td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
		<?php if (validate_action('alta') || validate_action('modificar')): ?>
			<input type="button" class="boton" value="Guardar" name="btn_guardado" onclick="setFrmValorEstado('guardado');"/>
			<input type="button" class="boton" value="Guardar Pendiente" name="btn_pendiente" onclick="setFrmValorEstado('pendiente');"/>
			<?php if (validate_action('publicar')): ?>
				<input type="button" class="boton" value="Guardar Publicado" name="btn_publicado" onclick="setFrmValorEstado('publicado');"/>
			<?php endif;?>
		<?php endif;?>
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('contenidos/index?page='.$pageActual) ?>';"/>
		<input type="hidden" name="frm_valor_estado" id="hid_valor_estado" value="publicado" />
	</div>
</form>