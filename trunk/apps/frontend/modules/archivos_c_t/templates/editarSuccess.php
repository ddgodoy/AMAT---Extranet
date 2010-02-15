
<div class="mapa"><strong>Consejos Territoriales</strong> &gt; <a href="<?php echo url_for('archivos_c_t/index') ?>">Archivos</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Archivos de Documentación de onsejos Territoriales</h1></td>
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
	
	$grupos_trabajo_selected = 0;//$form->getObject()->getGrupoTrabajoId();
	$documentacion_selected = $form->getObject()->getDocumentacionConsejoId();
	$arrayDocumentacion = array();

	if (!empty($documentacion_selected))
	{
		$grupos_trabajo_selected = Doctrine::getTable('DocumentacionConsejo')->find($documentacion_selected)->getConsejoTerritorialId();
		$arrayDocumentacion = DocumentacionConsejoTable::DocumentacionByConsejo($grupos_trabajo_selected);
	}
	
	
	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => $axInstance->getUser()->getAttribute($axInstance->getModuleName().'_nowpage'),
			'arrayGruposTrabajo'   => ArchivoCTTable::doSelectAllCategorias('ConsejoTerritorial'),			
			'arrayDocumentacion'=> $arrayDocumentacion,
			'grupos_trabajo_selected' => $grupos_trabajo_selected,
			'documentacion_selected'  => $documentacion_selected
		)
  );
?>