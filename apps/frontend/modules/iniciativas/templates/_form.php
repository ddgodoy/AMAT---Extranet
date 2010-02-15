<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['categoria_iniciativa_id']->renderError() ?>
<?php echo $form['subcategoria_iniciativa_id']->renderError() ?>
<?php echo $form['contenido']->renderError() ?>
<?php echo $form['documento']->renderError() ?>

<form action="<?php echo url_for('iniciativas/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
		<legend>Iniciativas</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><label><?php echo $form['fecha']->renderLabel() ?></label></td>
			          <td width="93%" valign="middle">
			            <?php echo $form['fecha'] ?>	            
			            </td>
				</tr>
				<tr>
					<td width="7%"><?php echo $form['nombre']->renderLabel() ?></td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td width="7%"><?php echo $form['categoria_iniciativa_id']->renderLabel() ?></td>
					<td width="93%" valign="middle"><?php echo $form['categoria_iniciativa_id']; echo observe_field('iniciativa_categoria_iniciativa_id',array('update'=>'sub','url'=>'iniciativas/subcategorias','with'=>"'id_categoria='+value")) ?></td>
				</tr>
				<tr>
					<td width="7%"><?php echo $form['subcategoria_iniciativa_id']->renderLabel() ?></td>
					<td width="93%" valign="middle" id="sub"><?php echo $form['subcategoria_iniciativa_id'] ?></td>
				</tr>
				<tr>
					<td valign="top"><label><?php echo $form['contenido']->renderLabel() ?></label></td>
					<td valign="middle"><?php echo $form['contenido'] ?></td>
				</tr>
				<tr>
			          <td style="padding-top: 5px;"><label>Documento</label></td>
			          <td style="padding-top: 5px;"><label>
			            <?php echo $form['documento'] ?>
			          </label></td>
		        </tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
	<?php if(validate_action('alta') || validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php endif; ?>	
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('iniciativas/index?page='.$pageActual) ?>';"/>
	</div>
</form>