<?php
	use_helper('Javascript');
	use_helper('Security');
	use_helper('Object');
	
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form->renderGlobalErrors()
?>
<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php
	echo $form['fecha']->renderError();
	echo $form['fecha_caducidad']->renderError();
	echo $form['nombre']->renderError();
	echo $form['disponibilidad']->renderError();
	echo $form['grupo_trabajo_id']->renderError();
	echo $form['documentacion_grupo_id']->renderError();
	echo $form['archivo']->renderError();
	echo $form['contenido']->renderError();
?>
<?php if (!DocumentacionGrupoTable::getAlldocumentos()->count()): ?>
<div class="mensajeSistema ok">Debe ingresar un documento para poder cargar un archivo de documentacion del grupo de trabajo. <a href="<?php echo url_for('documentacion_grupos/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('archivos_d_g/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <legend>Archivos de Grupos de Trabajo</legend>
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
        <tbody>
        <tr>
          <td width="7%"><label>Fecha *</label></td>
          <td width="93%" valign="middle">
            <?php echo $form['fecha'] ?>                        
            <label style="margin-left: 4px;">Fecha de Caducidad *</label> <?php echo $form['fecha_caducidad'] ?>                  
          </td>
        </tr>
        <tr>
          <td><label>Título *</label></td>
          <td valign="middle"><?php echo $form['nombre'] ?>
          </td>
        </tr>
        <tr>
          <td><label>Disponibilidad *</label></td>
          <td valign="middle"><?php echo $form['disponibilidad'] ?>          
          </td>
        </tr>
        <tr>
          <td><label>Grupo de Trabajo *</label></td>
          <td valign="middle">
          	<?php 
							echo select_tag('grupo_trabajo_id',
															options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayGruposTrabajo), $grupos_trabajo_selected),
															array('style'=>'width:330px;','class'=>'form_input')
														 );
							echo observe_field('grupo_trabajo_id', array('update'=>'content_documentacion','url'=>'documentacion_grupos/listByGrupoTrabajo','with'=>"'id_grupo_trabajo='+value"));
						?>
          </td>
        </tr>
        <tr>
          <td><label>Documentacion *</label></td>
          <td valign="middle">
          	<span id="content_documentacion">
							<?php include_partial('documentacion_grupos/selectByGrupoTrabajo', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$documentacion_selected)) ?>
						</span>
          </td>
        </tr>
        <tr>
          <td style="padding-top: 5px;"><label>Archivo *</label></td>
          <td style="padding-top: 5px;"><label><?php echo $form['archivo'] ?></label></td>
        </tr>
        <tr>
          <td valign="top" style="padding-top: 5px;"><label>Descripci&oacute;n *</label></td>
          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
        </tr>
      </tbody>
      </table>
      <?php echo $form->renderHiddenFields() ?>
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif; ?>   
      <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_d_g/index') ?>';"/>
    </div>
 </form>