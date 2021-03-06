
<div class="mapa"><strong>Organismos</strong> &gt; <a href="<?php echo url_for('documentacion_organismos/index') ?>">Documentación</a> &gt; Nueva</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Documentación de Organismos</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
<?php
 $organismos = 0 ;
 $subcategoria = 0;
 if(sfConfig::get('sf_environment') == 'dev'){
    if($sf_request->getParameter('documentacion_organismo[organismo_id]')):
    $organismos =  $sf_request->getParameter('documentacion_organismo[organismo_id]');
    endif;
    if($sf_request->getParameter('documentacion_organismo[subcategoria_organismo_id]')):
    $subcategoria =  $sf_request->getParameter('documentacion_organismo[subcategoria_organismo_id]');
    endif;
 }else{
  if($sf_request->getParameter('documentacion_organismo%5Borganismo_id%5D')):
  $organismos =  $sf_request->getParameter('documentacion_organismo%5Borganismo_id%5D');
  endif;
  if($sf_request->getParameter('documentacion_organismo%5Bsubcategoria_organismo_id%5D')):
    $subcategoria =  $sf_request->getParameter('documentacion_organismo%5Bsubcategoria_organismo_id%5D');
    endif;
 }

// datos que son utiles para los partial
$organismosArray = array('0'=>'','1'=>'');
if($organismos != 0){
$organismosArray = Organismo::getUrlOrganismos($organismos,1);
}
include_partial(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,	
			'arraySubcategoria'=> $organismosArray['1'],
			'arrayOrganismo'=> $organismosArray['0'],
			'verSubcategoria'=> 0,
			'subcategoria_organismos_selected'  => $subcategoria,
			'organismos_selected'  => $organismos,
			'verLosOrganismos' => $verLosOrganismos
		)); ?>
