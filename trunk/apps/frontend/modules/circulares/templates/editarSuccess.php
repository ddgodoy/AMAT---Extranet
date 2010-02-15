<div class="mapa">
	<!--<strong><?php //echo __('Administraci&oacute;n') ?> </strong>&gt;-->
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('iniciativas/index') ?>">Iniciativas</a> &gt; 
	Actualizar Iniciativa
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Actualizar Iniciativa</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>

<?php
	$axInstance = sfContext::getInstance();

	$cat_tema_selected = 0;
	$categoria_organismos_selected  = 0;
	$sub_tema_selected = $form->getObject()->getCircularSubTemaId();
	$subcategoria_organismos_selected  = $form->getObject()->getSubcategoriaOrganismoId();
	$arraySubcategoriasTema = array();
	$arraySubcategoria  = array();

	if (!empty($sub_tema_selected)) {
		$cat_tema_selected = Doctrine::getTable('CircularSubTema')->find($sub_tema_selected)->getCircularCatTemaId();
		$arraySubcategoriasTema = CircularSubTemaTable::doSelectByCategoria($cat_tema_selected);
	}
	if (!empty($subcategoria_organismos_selected)) {
		$categoria_organismos_selected = Doctrine::getTable('SubCategoriaOrganismo')->find($subcategoria_organismos_selected)->getCategoriaOrganismoId();
		$arraySubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($categoria_organismos_selected);
	}

	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => $axInstance->getUser()->getAttribute($axInstance->getModuleName().'_nowpage'),
			'arrayCategoriasTema'   => CircularTable::doSelectAllCategorias('CircularCatTema'),
			'arrayCategoria'    => ArchivoCTTable::doSelectAllCategorias('CategoriaOrganismo'),
			'arraySubcategoriasTema'=> $arraySubcategoriasTema,
			'arraySubcategoria' => $arraySubcategoria,
			'cat_tema_selected' => $cat_tema_selected,
			'categoria_organismos_selected' => $categoria_organismos_selected,			
			'sub_tema_selected' => $sub_tema_selected,
			'subcategoria_organismos_selected'  => $subcategoria_organismos_selected
		)
  );
?>