<div class="mapa">
	<!--<strong><?php //echo __('Administraci&oacute;n') ?> </strong>&gt;-->
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('circulares/index') ?>">Circulares</a> &gt; 
	Crear Circular
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Nueva Circular</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>

<?php
	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,
			'arrayCategoriasTema'   => CircularTable::doSelectAllCategorias('CircularCatTema'),
			'arrayCategoria'        => OrganismoTable::doSelectAllCategorias('CategoriaOrganismo'),
			'arraySubcategoriasTema'=> array(),
			'arraySubcategoria'     => array(),
			'cat_tema_selected' => 0,
			'categoria_organismos_selected'  => 0,
			'sub_tema_selected' => 0,
			'subcategoria_organismos_selected'  => 0
		)
  );
  
  
  /*
  include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,
			'arrayCategoriasTema'   => CircularTable::doSelectAllCategorias('CircularCatTema'),
			'arrayCategoriasOrg'    => CircularTable::doSelectAllCategorias('CircularCatOrg'),
			'arraySubcategoriasTema'=> array(),
			'arraySubcategoriasOrg' => array(),
			'cat_tema_selected' => 0,
			'cat_org_selected'  => 0,
			'sub_tema_selected' => 0,
			'sub_org_selected'  => 0
		)
  );
  
  */
?>