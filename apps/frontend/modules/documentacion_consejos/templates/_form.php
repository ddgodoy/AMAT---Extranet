<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['consejo_territorial_id']->renderError() ?>
<?php echo $form['categoria_c_t_id']->renderError() ?>
<?php echo $form['fecha']->renderError() ?>


<form action="<?php echo url_for('documentacion_consejos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
          <td width="7%"><label>Fecha *</label></td>
          <td width="93%" valign="middle">
            <?php echo $form['fecha'] ?>              
          </td>
        </tr>
        <tr>
          <td><label>Título*</label></td>
          <td valign="middle"><?php echo $form['nombre'] ?>         
          </td>
        </tr>
        <tr>
          <td><label>Consejos Territoriales *</label></td>
          <td valign="middle"><?php echo $form['consejo_territorial_id'] ?>          
          </td>
        </tr>
        <tr>
          <td><label>Categoría *</label></td>
          <td valign="middle"><?php echo $form['categoria_c_t_id'] ?>          
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top: 5px;"><label>Descripción</label></td>
          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
        </tr>    
        
      </tbody></table>
      
      <?php echo $form->renderHiddenFields() ?>  
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar Pendiente" name="btn_action"/>
    <?php endif;
    if(validate_action('publicar')):?>  
      <input type="submit" id="boton_publicar" class="boton" value="Guardar Publicado" name="btn_volver2"/>
     <?php endif;?> 
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_consejos/index') ?>';"/>
    </div>
</form>    
<?php if(validate_action('alta')):?>
<script>

$('boton_guardar').observe('click', setPendiente);
function setPendiente(event) {
	$('documentacion_consejo_estado').value = 'pendiente';
}
</script>
<?php endif;?>
<?php if(validate_action('publicar')):?>
<script>
$('boton_publicar').observe('click', setPublicado);
function setPublicado(event) {
	$('documentacion_consejo_estado').value = 'publicado';
}
</script>
<?php endif;?>