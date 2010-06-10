<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php use_helper('Object') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
<?php if($sf_request->getParameter('documentacion_organismo[organismo_id]')):$redireccionGrupo = Organismo::getUrlOrganismos($sf_request->getParameter('documentacion_organismo[organismo_id]')); else: $redireccionGrupo = '';  endif; ?>
<?php echo $form['nombre']->renderError() ?>
<?php echo $form['fecha']->renderError() ?>
<?php echo $form['categoria_organismo_id']->renderError() ?>
<?php echo $form['subcategoria_organismo_id']->renderError() ?>
<?php echo $form['organismo_id']->renderError() ?>
<?php if ($verLosOrganismos == 0):?>
<div class="mensajeSistema ok">Debe ingresar un organismo para poder cargar documentacion del organismos. <a href="<?php echo url_for('organismos/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('documentacion_organismos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId().'&'.$redireccionGrupo : '?'.$redireccionGrupo)) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <legend>Documentacion de Organismos</legend>
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
		<td><label> Categoría *</label></td>
		<td valign="middle">
		<?php
		// llamo al componente del modulo  categoria _ organismos
                   $categoria = $sf_request->getParameter('documentacion_organismo[categoria_organismo_id]')?$sf_request->getParameter('documentacion_organismo[categoria_organismo_id]'):'';
		   echo include_component('categoria_organismos','listacategoria',array('name'=>'documentacion_organismo','categoria'=>$categoria));
		?>
		</td>
		</tr>
		<tr>
		<td><label> Subcategoría *</label></td>
		<td valign="middle">
		<span id="content_subcategoria">
		<?php 
		// llamo al partial que se encuentra subcategoria _ organismos/selectByCategoriaOrganismo para que luego lo reescriba el componente del modulo  categoria _ organismos
		include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected,'name'=>'documentacion_organismo')); 
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
          	include_partial('organismos/listByOrganismos', array ('arrayOrganismo'=>$arrayOrganismo, 'organismos_selected'=>$organismos_selected,'name'=>'documentacion_organismo'))           	
          	?>
          </span>    
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
      <input type="submit" id="boton_guardar_g" class="boton" value="Guardar" name="btn_action"/>
    <?php endif;
     if(validate_action('alta')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar Pendiente" name="btn_action"/>
    <?php endif;
    if(validate_action('publicar')):
    ?>  
      <input type="submit" id="boton_publicar" class="boton" value="Guardar Publicado" name="btn_volver2"/>
     <?php endif; ?> 
      <input type="button"  id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_organismos/index?'.$redireccionGrupo) ?>';"/>
    </div>
 </form> 
<?php if(validate_action('alta')):?>
<script language="javascript" type="text/javascript">
	$('boton_guardar_g').observe('click', setGuardar);  function setGuardar(event) {$('documentacion_organismo_estado').value = 'guardado';}	
</script>
<?php 
endif;if(validate_action('alta')):?>
<script>

$('boton_guardar').observe('click', setPendiente);
function setPendiente(event) {
	$('documentacion_organismo_estado').value = 'pendiente';
}
</script>
<?php endif;?>
<?php if(validate_action('publicar')):?>
<script>
$('boton_publicar').observe('click', setPublicado);
function setPublicado(event) {
	$('documentacion_organismo_estado').value = 'publicado';
}
</script>
<?php endif;?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    