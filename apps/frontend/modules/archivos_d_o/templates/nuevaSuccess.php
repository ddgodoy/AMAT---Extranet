
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

$getDocumentacion = '';
$getOrganismo = '';
if(sfConfig::get('sf_environment') == 'dev'){
if($sf_request->getParameter('archivo_d_o[documentacion_organismo_id]')){
$getDocumentacion = $sf_request->getParameter('archivo_d_o[documentacion_organismo_id]');
$getOrganismo = $sf_request->getParameter('archivo_d_o[organismo_id]');
}
}else{
if($sf_request->getParameter('archivo_d_o%5Bdocumentacion_organismo_id%5D')){
$getDocumentacion = $sf_request->getParameter('archivo_d_o%5Bdocumentacion_organismo_id%5D');
$getOrganismo = $sf_request->getParameter('archivo_d_o%5Borganismo_id%5D');
}
}

if($sf_context->getActionName() == 'nueva' && $getOrganismo != ''){
    $organismo = Doctrine::getTable('Organismo')->findOneById($getOrganismo);
    $categoria = $organismo->getCategoriaOrganismoId();
    $verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($categoria);
    $idSubcategoria = $organismo->getSubcategoriaOrganismoId();
    $verOrganisamos = OrganismoTable::doSelectByOrganismoa($organismo->getSubcategoriaOrganismoId());
    $idOrganismos = $organismo->getId();
    $verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($organismo->getId(),1,$sf_user->getAttribute('userId'));
    $idDocumentacion = $getDocumentacion?$getDocumentacion:'';
}

if($sf_context->getActionName() == 'create'){
    $verSubcategoria = SubCategoriaOrganismoTable::doSelectByCategoria($form['categoria_organismo_id']->getValue());
    $idSubcategoria = $form['subcategoria_organismo_id']->getValue();
    $verOrganisamos = OrganismoTable::doSelectByOrganismoa($form['subcategoria_organismo_id']->getValue());
    $idOrganismos = $form['organismo_id']->getValue();
    $verDocumentacion = DocumentacionOrganismoTable::doSelectByOrganismo($form['organismo_id']->getValue(),1,$sf_user->getAttribute('userId'));
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