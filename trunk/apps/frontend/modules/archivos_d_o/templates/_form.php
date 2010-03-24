<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php use_helper('Object') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['disponibilidad']->renderError() ?>
<?php echo $form['fecha']->renderError() ?>
<?php echo $form['fecha_caducidad']->renderError() ?>
<?php if ($verLadocumentacion == 0):?>
<div class="mensajeSistema ok">Debe ingresar un documento para poder cargar un archivo de documentacion del Organismo. <a href="<?php echo url_for('documentacion_organismos/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('archivos_d_o/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <legend>Archivos de Organismos</legend>
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
        <tbody>
        <tr>
          <td width="9%"><label>Fecha *</label></td>
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
		<td><label> Categoría *</label></td>
		<td valign="middle">
		<?php
		// llamo al componente del modulo  categoria _ organismos
		   echo include_component('categoria_organismos','listacategoria',array('categoria'=>$form['categoria_organismo_id']->getValue() ,'name'=>'archivo_d_o'));
		?>
		</td>
		</tr>
		<tr>
			<td><label> Subcategoría *</label></td>
			<td valign="middle">
			<span id="content_subcategoria">
			<?php 
			// llamo al partial que se encuentra subcategoria _ organismos/selectByCategoriaOrganismo para que luego lo reescriba el componente del modulo  categoria _ organismos
			include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected, 'name'=>'archivo_d_o')); 
			?>
			</span>
			</td>
		</tr>
        <tr>
          <td><label>Organismo *</label></td>
          <td valign="middle">
          <span id="content_organismos">              
          	<?php 
          	// llamo al partial que se encuentra organismos/listByOrganismos para que luego lo reescriba el componente del modulo  subcategoria _ organismos
          	include_partial('organismos/listByOrganismos', array ('arrayOrganismo'=>$arrayOrganismo, 'organismos_selected'=>$organismos_selected, 'name'=>'archivo_d_o'))?>
          </span>    
          </td>
        </tr>

        <tr>
          <td><label>Documentacion *</label></td>
          <td valign="middle">
          	<span id="content_documentacion"> 
			<?php include_partial('documentacion_organismos/selectByOrganismo', array ('arrayDocumentacion'=>$arrayDocumentacion, 'documentacion_selected'=>$documentacion_selected, 'name'=>'archivo_d_o')) ?>
			</span>       
          </td>
        </tr> 
        <tr>
          <td style="padding-top: 5px;"><label>Archivo </label></td>
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
      <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_d_o/index') ?>';"/>
    </div>

</form>