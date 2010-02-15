<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
<?php echo $form['subcategoria_normativa_id']->renderError() ?>
<?php if (!SubCategoriaNormativaN1Table::getAll()->count()):?>
<div class="mensajeSistema ok">Debe ingresar una Sub categoría (nivel 1) para poder cargar Subcategorías de Normativas (nivel 2). <a href="<?php echo url_for('subcategoria_normativa_n1/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('subcategoria_normativa_n2/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      <legend>Subcategorías Normativa (nivel 2)</legend>
      	
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%" style="font-size:11px;"> Título *</td>
					<td width="93%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td width="7%" style="font-size:11px;"> Categoria *</td>
					<td width="93%" valign="middle"><?php echo $form['categoria_normativa_id'];
					echo observe_field('sub_categoria_normativa_n2_categoria_normativa_id',array('update'=>'sub','url'=>'subcategoria_normativa_n2/subcategorias','with'=>"'id_categoria='+value"))?></td>
				</tr>
				<tr>
					<td width="7%" style="font-size:11px;">Sub Categoría (nivel 1) *</td>
					<td width="93%" valign="middle" id="sub"><?php echo $form['subcategoria_normativa_id'] ?></td>
				</tr>
				<tr>
					<td width="7%" style="font-size:11px;"> Contenido </td>
					<td width="93%" valign="middle"><?php echo $form['contenido'] ?></td>
				</tr>
			</tbody>
		</table>
      
      <?php echo $form->renderHiddenFields() ?>
      
   
      
    </fieldset>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
    <?php endif;?>  
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('subcategoria_normativa_n2/index') ?>';"/>
    </div>
 </form>