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
<?php echo $form['grupo_trabajo_id']->renderError() ?>
<?php echo $form['categoria_organismo_id']->renderError() ?>
<?php echo $form['subcategoria_organismo_id']->renderError() ?>
<?php echo $form['usuarios_list']->renderError(); ?>
<?php if (!SubCategoriaOrganismoTable::getAllsubcategoriaOrg()->count()):?>
<div class="mensajeSistema ok">Debe ingresar una subcategoría para poder cargar un nuevo organismo. <a href="<?php echo url_for('subcategoria_organismos/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('organismos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
      </tr>
    </tbody></table>
    <div class="botonera" style="padding-top:10px;">
    </div>
    <fieldset>
      <legend>Nuevo Organismo</legend>
      	
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="9%"><label> Título *</label></td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td><label>  Grupo de Trabajo *</label></td>
					<td valign="middle"><?php echo $form['grupo_trabajo_id'] ?></td>
				</tr>
				<tr>
					<td><label> Categoría *</label></td>
					<td valign="middle">
					<?php 
							echo select_tag('organismo[categoria_organismo_id]',
															options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayCategoria), $categoria_organismos_selected),
															array('style'=>'width:330px;','class'=>'form_input')
														 );
							echo observe_field('organismo_categoria_organismo_id', array('update'=>'content_subcategoria','url'=>'subcategoria_organismos/listByCategoriaOrganismo','with'=>"'id_categoria_organismo='+value+'&name=organismo'"));
					?>
					
					</td>
				</tr>
				<tr>
					<td><label> Subcategoría *</label></td>
					<td valign="middle">
						<span id="content_subcategoria">
								<?php include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected, 'name'=>'organismo')) ?>
						</span>     
					</td>
				</tr>
				<tr>
					<td width="9%"><label> Detalle *</label></td>
					<td width="93%" valign="middle"><?php echo $form['detalle'] ?></td>
				</tr>
			</tbody>
		</table>
	<div class="clear"></div>
	<div class="clear"></div>
	<br/>
	<?php if ($form->getObject()->isNew()): ?>
	<div class="mensajeSistema ok">Los usuarios del Organismo podrán seleccionarse luego de guardarlo </div>
	<?php endif; ?>
	<?php if (!$form->getObject()->isNew()): ?>
	<fieldset style="float:left; margin-right:10px;width:445px; ">
      <legend>Usuarios del Organismo</legend><br />
      <span style="float:left"><?php echo $form['usuarios_list'] ?>
      </span>
    </fieldset>
    <?php endif; ?>
    
      <?php echo $form->renderHiddenFields() ?>
      
    
    
    </fieldset>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif; ?>  
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('organismos/index') ?>';"/>
      <?php if (!$form->getObject()->isNew()): ?>
	  <input type="button" id="boton_cancel" class="boton" value="Volver al listado" name="boton_cancel" onclick="document.location='<?php echo url_for('organismos/index') ?>';"/>
	  <?php endif; ?>
    </div>
</form>