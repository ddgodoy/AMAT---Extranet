<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Security');?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['detalle']->renderError() ?>


<form action="<?php echo url_for('mutuas/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
    <fieldset>
      <legend>Datos de Mutua</legend>
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
	  <tbody>
      <tr>
			<td width="5%"><?php echo $form['nombre']->renderLabel() ?></td>
			<td width="95%" valign="middle"><?php echo $form['nombre'] ?></td>
	  </tr>
	   <tr>
			<td width="5%"><?php echo $form['detalle']->renderLabel() ?></td>
			<td width="95%" valign="middle"><?php echo $form['detalle'] ?></td>
	  </tr>
	  </tbody>
	  </table>
    </fieldset>
    
    <div class="clear"></div>
    <div class="lineaListados" style="margin-top:5px;">
    <?php if(validate_action('alta') || validate_action('modificafr')):?>
      <input class="boton" name="Submit" type="submit" value="Guardar" />
     <?php endif;?> 
      <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('mutuas/index') ?>';"/>
    </div>
    <?php echo $form->renderHiddenFields() ?>
    <div class="clear"></div>
</form>