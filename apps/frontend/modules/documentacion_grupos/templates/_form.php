<?php
	use_helper('Javascript');
	use_helper('Security');
	
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form->renderGlobalErrors();
	
	$docGT_NowGrupo = $sf_user->getAttribute('documentacion_grupos_nowgrupo') ? $sf_user->getAttribute('documentacion_grupos_nowgrupo') : 0;
?>
<?php if($sf_request->getParameter('grupo')){
$redireccionGrupo = 'grupo='.$sf_request->getParameter('grupo');
}else{
$redireccionGrupo = '';
} ?>
<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
<?php
	echo $form['nombre']->renderError();
	echo $form['grupo_trabajo_id']->renderError();
	echo $form['categoria_d_g_id']->renderError();
	echo $form['fecha']->renderError();
?>
<?php if (!CategoriaDGTable::getAllcategoria()->count()):?>
<div class="mensajeSistema ok">Debe ingresar una categoría para poder cargar un documento del grupo de trabajo. <a href="<?php echo url_for('categorias_d_g/index') ?>">click aquí</a></div>
<?php endif;?>

<form action ="<?php echo url_for('documentacion_grupos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId().'&'.$redireccionGrupo : '?'.$redireccionGrupo)) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
          <td><label>Grupo de Trabajo *</label></td>
          <td valign="middle">
          	<?php echo $form['grupo_trabajo_id'] ?>
          	<label id="adver" style="display:none;color:red;">
          		&nbsp;* Se registrar&aacute; el documento con otro Grupo de Trabajo distinto al que usted esta trabajando
          	</label>
          </td>
        </tr>
        <tr>
          <td><label>Categoría *</label></td>
          <td valign="middle"><?php echo $form['categoria_d_g_id'] ?>          
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top: 5px;"><label>Descripción</label></td>
          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
        </tr>
      </tbody>
      </table>
      <?php echo $form->renderHiddenFields() ?>
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta')):?>
      <input type="submit" id="boton_guardar_g" class="boton" value="Guardar" name="btn_action"/>
    <?php endif;
     if(validate_action('alta')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar Pendiente" name="btn_action"/>
    <?php endif;
    if(validate_action('publicar')):
    ?>  
      <input type="submit" id="boton_publicar" class="boton" value="Guardar Publicado" name="btn_volver2"/>
     <?php endif; ?> 
      <input type="button"  id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_grupos/index?'.$redireccionGrupo) ?>';"/>
    </div>
 </form> 
<?php if(validate_action('alta')):?>
<script language="javascript" type="text/javascript">
	$('boton_guardar_g').observe('click', setGuardar);  function setGuardar(event) {$('documentacion_grupo_estado').value = 'guardado';}	
</script>
<?php 
endif; if(validate_action('alta')):?>
	<script language="javascript" type="text/javascript">
		$('boton_guardar').observe('click', setPendiente);

		function setPendiente(event)
		{
			$('documentacion_grupo_estado').value = 'pendiente';
		}
		$('documentacion_grupo_grupo_trabajo_id').observe('change', function() {
			if (jQuery('#documentacion_grupo_grupo_trabajo_id').val() != <?php echo $docGT_NowGrupo ?>) {
				if ($('adver').style.display == 'none') {
					$('adver').style.display = 'block';	
				}
			} else {
				$('adver').style.display = 'none';
			}
		});
	</script>
<?php endif;?>
<?php if(validate_action('publicar')):?>
	<script language="javascript" type="text/javascript">
		$('boton_publicar').observe('click', setPublicado);

		function setPublicado(event) { $('documentacion_grupo_estado').value = 'publicado'; }
	</script>
<?php endif;?>