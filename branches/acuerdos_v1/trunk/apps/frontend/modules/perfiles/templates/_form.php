<?php
use_helper('Javascript');
use_helper('Security');
include_stylesheets_for_form($form);
?>
<?php include_javascripts_for_form($form) ?>
<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
<?php 
echo $form->renderGlobalErrors();
echo $form['nombre']->renderError();
echo $form['codigo']->renderError();
echo $form['detalle']->renderError();
?>
<form action="<?php echo url_for('perfiles/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
       <tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
       </tr>
     </tbody>
</table>
<fieldset>
<legend>Perfiles</legend>
  <table>
    <tbody>
      <tr>
        <th><?php echo $form['nombre']->renderLabel('Nombre*') ?></th>
        <td>
          <?php echo $form['nombre'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['codigo']->renderLabel('Codigo*') ?></th>
        <td>
          <?php echo $form['codigo'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['detalle']->renderLabel() ?></th>
        <td>
          <?php echo $form['detalle'] ?>
        </td>
      </tr>
    </tbody>
  </table> 
    <?php echo $form->renderHiddenFields() ?>
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta')):?> 
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif; ?>
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('perfiles/index') ?>';"/>
    </div>
</form>   