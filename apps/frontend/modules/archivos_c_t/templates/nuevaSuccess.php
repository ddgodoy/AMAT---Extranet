
<div class="mapa"><strong>Consejos Territoriales</strong> &gt; <a href="<?php echo url_for('archivos_c_t/index') ?>">Archivos de Documentación</a> &gt; Nueva</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Archivos de Documentación de Consejos Territoriales</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	

<?php
	include_partial
	(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,
			'arrayGruposTrabajo'   => ArchivoCTTable::doSelectAllCategorias('ConsejoTerritorial'),			
			'arrayDocumentacion'=> array(),
			'grupos_trabajo_selected' => 0,
			'documentacion_selected'  => 0
		)
  );
?>