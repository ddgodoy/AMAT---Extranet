
<div class="mapa"><strong>Grupos de Trabajo</strong> &gt; <a href="<?php echo url_for('archivos_d_g/index') ?>">Archivos</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Archivos de Documentación de Grupos de Trabajo</h1></td>
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
	$documentacion_selected = $form->getObject()->getDocumentacionGrupoId();
	$arrayDocumentacion = array();

	if (!empty($documentacion_selected))
	{
		$grupos_trabajo_selected = Doctrine::getTable('DocumentacionGrupo')->find($documentacion_selected)->getGrupoTrabajoId();
		$arrayDocumentacion = DocumentacionGrupoTable::doSelectByGrupoTrabajo($grupos_trabajo_selected);
	}
	
	$userId = $sf_user->getAttribute('userId');
	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => $axInstance->getUser()->getAttribute($axInstance->getModuleName().'_nowpage'),
			'arrayGruposTrabajo'   => GrupoTrabajo::ArrayDeMigrupo($userId, 1),
			'arrayDocumentacion'=> $arrayDocumentacion,
			'grupos_trabajo_selected' => $grupos_trabajo_selected,
			'documentacion_selected'  => $documentacion_selected
		)
  );
?>