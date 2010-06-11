
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
// datos que son utiles para los partial
$organismosArray = array('0'=>'','1'=>'');
if($sf_request->getParameter('documentacion_organismo[organismo_id]')){
$organismosArray = Organismo::getUrlOrganismos($sf_request->getParameter('documentacion_organismo[organismo_id]'),1);
}

echo $sf_->getGetParameter('documentacion_organismo[organismo_id]');
exit ();

if($sf_request->getParameter('documentacion_organismo[organismo_id]')):
$redireccionGrupo = Organismo::getUrlOrganismos($sf_request->getParameter('documentacion_organismo[organismo_id]'));
else: $redireccionGrupo = '';
endif;
include_partial(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,	
			'arraySubcategoria'=> $organismosArray['1'],
			'arrayOrganismo'=> $organismosArray['0'],
			'verSubcategoria'=> 0,
			'subcategoria_organismos_selected'  => $sf_request->getParameter('documentacion_organismo[subcategoria_organismo_id]')?$sf_request->getParameter('documentacion_organismo[subcategoria_organismo_id]'):0,
			'organismos_selected'  => $sf_request->getParameter('documentacion_organismo[organismo_id]')?$sf_request->getParameter('documentacion_organismo[organismo_id]'):0,
			'verLosOrganismos' => $verLosOrganismos
		)); ?>
