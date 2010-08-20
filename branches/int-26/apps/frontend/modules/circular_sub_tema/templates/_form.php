<?php
	use_helper('Javascript');
	use_helper('Security');

	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form['nombre']->renderError();
	echo $form['circular_cat_tema_id']->renderError();
?>
<?php if (!empty($circularCategoria) && count($circularCategoria) == 0):?>
<div class="mensajeSistema ok">Debe ingresar una categoría para poder cargar Subcategorías de Circulares. <a href="<?php echo url_for('circular_cat_tema/nueva') ?>">click aquí</a></div>
<?php endif;?>

<form action="<?php echo url_for('circular_sub_tema/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
		<legend>Circulares - Subcategor&iacute;a de Tema</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><?php echo $form['nombre']->renderLabel() ?></td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td><?php echo $form['circular_cat_tema_id']->renderLabel() ?></td>
					<td valign="middle"><?php echo $form['circular_cat_tema_id'] ?></td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
	    <?php if(validate_action('alta') || validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
		<?php endif;?>
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('circular_sub_tema/index?page='.$pageActual) ?>';"/>
	</div>
</form>