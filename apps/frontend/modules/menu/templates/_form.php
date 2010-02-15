<?php
	use_helper('Javascript');
	use_helper('Security');
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
?>
<?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form['nombre']->renderError() ?>
<form action="<?php echo url_for('menu/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
<div class="botonera">
    </div>
    <fieldset>
      <legend>Menu</legend>
    <table width="100%" cellspacing="5" cellpadding="0" border="0">
     <tbody>
     <?php echo $form['padre_id'] ?>
      <tr>
        <td><?php echo $form['nombre']->renderLabel('* Nombre') ?></td>
        <td>
          <?php echo $form['nombre'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['descripcion']->renderLabel() ?></td>
        <td>
          <?php echo $form['descripcion'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['aplicacion_id']->renderLabel('Aplicación') ?></td>
        <td>
          <?php echo $form['aplicacion_id'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['url_externa']->renderLabel() ?></td>
        <td>
          <?php echo $form['url_externa'] ?>
        </td>
      </tr>
       <tr>
        <td><?php echo $form['posicion']->renderLabel() ?></td>
        <td>
          <?php echo $form['posicion'] ?>
        </td>
      </tr>
      <tr>
      <td><?php echo $form['habilitado']->renderLabel() ?></td>
        <td>
          <?php echo $form['habilitado'] ?>
        </td>
      </tr>
    </tbody>
     <?php echo $form->renderHiddenFields() ?>
  </table>

 </fieldset>
    <div class="botonera">
          <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action" />
          <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('menu/index') ?>';">
    </div>
 </form>   