<?php
	use_helper('Javascript');
	use_helper('Object');
	use_helper('Security');
	
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
	
	echo $form['nombre']->renderError();
	echo $form['contenido']->renderError();
	echo $form['fecha']->renderError();
	echo $form['fecha_caducidad']->renderError();
	echo $form['numero']->renderError();
	echo $form['documento']->renderError();
	echo $form['circular_sub_tema_id']->renderError();
	echo $form['subcategoria_organismo_id']->renderError();
	echo $form['circular_tema_id']->renderError();
	echo $form['categoria_organismo_id']->renderError();
		
?>
<form action="<?php echo url_for('circulares/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>

	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="48%"><label>Los campos marcados con (*) son obligatorios</label></td>
				<td width="52%" align="right"></td>
			</tr>
		</tbody>
	</table>
	<br />
	<fieldset>
		<legend>Circulares</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>					
			          <td width="7%"><label>Fecha*</label></td>			            
			          <td width="93%" valign="middle">
			            <?php echo $form['fecha'] ?>			            
			            <label style="margin-left: 4px;"><?php echo $form['fecha_caducidad']->renderLabel() ?> </label><?php echo $form['fecha_caducidad'] ?>
			          </td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form['nombre']->renderLabel() ?></td>
					<td width="75%" valign="middle"><?php echo $form['nombre'] ?></td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form['numero']->renderLabel() ?></td>
					<td width="75%" valign="middle"><?php echo $form['numero'] ?></td>
				</tr>
				<tr>
		          <td width="15%"><?php echo $form['documento']->renderLabel() ?></td>
		          <td width="75%" valign="middle"><?php echo $form['documento'] ?></td>
		        </tr>
				<tr>
					<td valign="top"><label>Categor&iacute;a de Tema</label></td>
					<td valign="middle">
						<?php
							echo $form['circular_tema_id'];
							echo observe_field('circular_circular_tema_id', array('update'=>'content_sub_tema','url'=>'circular_sub_tema/listByCategoria','with'=>"'id_categoria='+value+'&name=circular'",'script'=>true));
							if ($form['circular_tema_id']->getValue()) {
						    $arraySubcategoriasTema = CircularSubTemaTable::doSelectByCategoria($form['circular_tema_id']->getValue());
							}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><label>Subcategor&iacute;a de Tema</label></td>
					<td valign="middle">
						<span id="content_sub_tema">
							<?php include_partial('circular_sub_tema/selectByCategoria', array ('arraySubcategoriasTema'=>$arraySubcategoriasTema, 'sub_tema_selected'=>$sub_tema_selected, 'name'=>'circular')) ?>
						</span>
					</td>
				</tr>
				<tr>
					<td valign="top"><label>Categor&iacute;a de Organismo</label></td>
					<td valign="middle">
						<?php
							echo $form['categoria_organismo_id'] ;
							echo observe_field('circular_categoria_organismo_id', array('update'=>'content_sub_org','url'=>'subcategoria_organismos/listByCategoriaOrganismo','with'=>"'id_categoria_organismo='+value+'&name=circular'"));
							if ($form['categoria_organismo_id']->getValue()) {
								$arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($form['categoria_organismo_id']->getValue());
						    }
						?>

					</td>
				</tr>
				<tr>
					<td valign="top"><label>Subcategor&iacute;a de Organismo</label></td>
					<td valign="middle">
						<span id="content_sub_org">
							<?php include_partial('subcategoria_organismos/selectByCategoriaOrganismo', array ('arraySubcategoria'=>$arraySubcategoria, 'subcategoria_organismos_selected'=>$subcategoria_organismos_selected, 'name'=>'circular')) ?>
							<?php /* include_partial('circular_sub_org/selectByCategoria', array ('arraySubcategoriasOrg'=>$arraySubcategoriasOrg, 'sub_org_selected'=>$sub_org_selected))  */?>
						</span>
					</td>
				</tr>
				<tr>
					<td valign="top"><label><?php echo $form['contenido']->renderLabel() ?></label></td>
					<td valign="middle"><?php echo $form['contenido'] ?></td>
				</tr>
			</tbody>
		</table>
		<?php echo $form->renderHiddenFields() ?>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
	<?php if(validate_action('alta') || validate_action('modificar')):?>
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php endif; ?>	
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('circulares/index?page='.$pageActual) ?>';"/>
	</div>
</form>