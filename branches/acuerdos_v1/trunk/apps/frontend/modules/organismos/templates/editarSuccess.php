
<div class="mapa"><strong>Organismos</strong> &gt; <a href="<?php echo url_for('organismos/index') ?>">Gestión de Organismos</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Editar Organismo</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	
<?php
	$axInstance = sfContext::getInstance();
	
	$categoria_organismos_selected = 0;
	$subcategoria_organismos_selected = $form->getObject()->getSubcategoriaOrganismoId();
	$arraySubcategoria = array();

	if (!empty($subcategoria_organismos_selected))
	{
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
			'arrayCategoria'   => ArchivoCTTable::doSelectAllCategorias('CategoriaOrganismo'),			
			'arraySubcategoria'=> $arraySubcategoria,
			'categoria_organismos_selected' => $categoria_organismos_selected,
			'subcategoria_organismos_selected'  => $subcategoria_organismos_selected
		)
  );
?>
