<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
<?php echo $form['titulo']->renderError() ?>
<?php echo $form['grupo_trabajo_id']->renderError() ?>
<form action="<?php echo url_for('normas_de_funcionamientos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
 <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
      </tr>
    </tbody></table>
    <div class="botonera">
    </div>
    <fieldset>
      <legend>Documentacion de Grupos de Trabajo</legend>
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
        <tbody>
         <tr>
          <td width="10%"><label>Grupo de Trabajo *</label></td>
          <td  width="90%" valign="middle"><?php echo $form['grupo_trabajo_id'] ?>          
          </td>
        </tr>         
        <tr>
          <td width="7%"><label>Título*</label></td>
          <td  width="93%" valign="middle"><?php echo $form['titulo'] ?>         
          </td>
        </tr>
        <tr>
          <td width="7%"><label>Descripcion*</label></td>
          <td  width="93%" valign="middle"><?php echo $form['descripcion'] ?>          
          </td>
        </tr>
      </tbody></table>
      
      <?php echo $form->renderHiddenFields() ?>
        
    </fieldset>
      <div class="botonera">
    <?php if(validate_action('alta')):?>
      <input type="submit" id="boton_publicar" class="boton" value="Guardar" name="btn_volver2"/>
     <?php endif; ?> 
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('normas_de_funcionamientos/index') ?>';"/>
    </div>
 
</form>
