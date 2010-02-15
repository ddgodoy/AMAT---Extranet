
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
include_partial(
		'form',
		array
		(
			'form' => $form,
			'pageActual' => 1,	
			'arraySubcategoria'=> array(),
			'arrayOrganismo'=> array(),
			'arrayDocumentacion' => array(),
			'verSubcategoria'=> 0,
			'subcategoria_organismos_selected'  => 0,
			'organismos_selected'=> 0,
			'documentacion_selected'=>0,
			'verLadocumentacion' => $verLadocumentacion
		));
?>