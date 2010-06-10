
<div class="mapa"><strong>Organismos</strong> &gt; <a href="<?php echo url_for('archivos_d_g/index') ?>">Archivos de Documentación</a> &gt; Nueva</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Archivos de Documentación de Organismos</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

<?php 
// datos que son utiles para los partial

$verSubcategoria = '';
$verOrganisamos = '';
$verDocumentacion = '';
$idSubcategoria = '';
$idOrganismos = '';
$idDocumentacion = '';
$categoria ='';

if($sf_context->getActionName() == 'nueva' && $sf_request->getParameter('archivo_d_o[organismo_id]')){
    $organismo = Doctrine::getTable('Organismo')->findOneById($sf_request->getParameter('archivo_d_o[organismo_id]'));
    $categoria = $organismo->getCategoriaOrganismoId();
    $verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($categoria);
    $idSubcategoria = $organismo->getSubcategoriaOrganismoId();
    $verOrganisamos = OrganismoTable::doSelectByOrganismoa($organismo->getSubcategoriaOrganismoId());
    $idOrganismos = $organismo->getId();
    $verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($organismo->getId(),1);
    $idDocumentacion = $sf_request->getParameter('archivo_d_o[documentacion_organismo_id]')?$sf_request->getParameter('archivo_d_o[documentacion_organismo_id]'):'';
}

if($sf_context->getActionName() == 'create'){
    $verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($form['categoria_organismo_id']->getValue());
    $idSubcategoria = $form['subcategoria_organismo_id']->getValue();
    $verOrganisamos = OrganismoTable::doSelectByOrganismoa($form['subcategoria_organismo_id']->getValue());
    $idOrganismos = $form['organismo_id']->getValue();
    $verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($form['organismo_id']->getValue(),1);
    $idDocumentacion = $form['documentacion_organismo_id']->getValue(); 
}    

include_partial(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,
                        'categoria'=>$categoria,
			'arraySubcategoria'=> $verSubcategoria?$verSubcategoria:array(),
			'arrayOrganismo'=> $verOrganisamos?$verOrganisamos:array(),
			'arrayDocumentacion'=> $verDocumentacion?$verDocumentacion:array(),
			'subcategoria_organismos_selected'=> $idSubcategoria,
			'organismos_selected'  => $idOrganismos,
			'documentacion_selected' => $idDocumentacion,
			'verLadocumentacion' => 1
		));
?>