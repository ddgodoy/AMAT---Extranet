<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['categoria_normativa_id']->renderError() ?>
<?php if (!CategoriaNormativaTable::getAll()->count()):?>
<div class="mensajeSistema ok">Debe ingresar una categoría para poder cargar Subcategorías de Normativa. <a href="<?php echo url_for('categoria_normativa/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('subcategoria_normativa_n1/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
      </tr>
    </tbody></table>
    <div class="botonera" style="padding-top:10px;">
    </div>
    <fieldset>
      <legend>Subcategorías Normativa (nivel 1)</legend>
      	
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%" style="font-size:11px;"> Título *</td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td width="7%" style="font-size:11px;"> Categoría *</td>
					<td width="93%" valign="middle"><?php echo $form['categoria_normativa_id'] ?></td>
				</tr>
				<tr>
					<td width="7%" style="font-size:11px;"> Contenido </td>
					<td width="93%" valign="middle"><?php echo $form['contenido'] ?></td>
				</tr>
			</tbody>
		</table>
      
      <?php echo $form->renderHiddenFields() ?>
      
   
      
    </fieldset>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif;?>  
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('subcategoria_normativa_n1/index') ?>';"/>
    </div>
 </form>