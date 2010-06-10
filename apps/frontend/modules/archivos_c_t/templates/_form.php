
<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php use_helper('Object') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
<?php if($sf_request->getParameter('archivo_c_t[documentacion_consejo_id]') && $sf_request->getParameter('consejo_territorial_id')): $redireccionGrupo = 'archivo_c_t[documentacion_consejo_id]='.$sf_request->getParameter('archivo_c_t[documentacion_consejo_id]').'&consejo_territorial_id='.$sf_request->getParameter('consejo_territorial_id'); else : $redireccionGrupo = ''; endif; ?>
<?php echo $form['nombre']->renderError() ?>
<?php echo $form['disponibilidad']->renderError() ?>
<?php echo $form['fecha']->renderError() ?>
<?php echo $form['archivo']->renderError() ?>
<?php echo $form['fecha_caducidad']->renderError() ?>

<?php if (!DocumentacionConsejoTable::getAlldocumentacionC()->count()):?>
<div class="mensajeSistema ok">Debe ingresar un documento para poder cargar un archivo de documentacion de Consejos Territoriales. <a href="<?php echo url_for('documentacion_consejos/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('archivos_c_t/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId().'&'.$redireccionGrupo : '?'.$redireccionGrupo)) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <legend>Archivos de Consejos Territoriales</legend>
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
           <td><label>Consejos Territoriales *</label></td>
          <td valign="middle">
          <?php 
            echo $form['consejo_territorial_id'];
			echo observe_field('archivo_c_t_consejo_territorial_id', array('update'=>'content_documentacion','url'=>'archivos_c_t/listDocumentacion','with'=>"'id_consejo='+value"));								 
			$arrayDocumentacion = array();
			if ($form['consejo_territorial_id']->getValue())
			{
				$arrayDocumentacion = DocumentacionConsejoTable::DocumentacionByConsejo($form['consejo_territorial_id']->getValue());
			}
           ?>          
          </td>
        </tr>
        <tr>
          <td><label>Documentacion *</label></td>
          <td valign="middle">
          <div id="content_documentacion">
          	<?php include_partial('archivos_c_t/listDocumentacion', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$form['documentacion_consejo_id']->getValue())) ?>
          </div>   
          </td>
        </tr> 
        <tr>
          <td style="padding-top: 5px;"><label>Archivo* </label></td>
          <td style="padding-top: 5px;"><label>
            <?php echo $form['archivo'] ?>
          </label></td>
        </tr>
        
        <tr>
          <td valign="top" style="padding-top: 5px;"><label>Descripción</label></td>
          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
        </tr>
      </tbody></table>
      
      <?php echo $form->renderHiddenFields() ?>
        
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif;?>
    
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_c_t/index?'.$redireccionGrupo) ?>';"/>
    </div> 
 </form>
    

