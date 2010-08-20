
<div class="mapa"><strong>Grupos de Trabajo</strong> &gt; <a href="<?php echo url_for('archivos_d_g/index') ?>">Archivos de Documentación</a> &gt; Nueva</div>
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
        $userId = $sf_user->getAttribute('userId');
	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,
			'arrayGruposTrabajo'   => GrupoTrabajo::ArrayDeMigrupo($userId, 1),
			'arrayDocumentacion'=> array(),
			'grupos_trabajo_selected' => 0,
			'documentacion_selected'  => 0,
		)
  );
?>