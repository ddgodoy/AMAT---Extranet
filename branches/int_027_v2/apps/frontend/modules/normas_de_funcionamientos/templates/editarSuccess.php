<div class="mapa"><strong>Grupos de Trabajo</strong> &gt; <a href="<?php echo url_for('normas_de_funcionamientos/index') ?>">Normas de funcionamiento</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Editar Normas de funcionamiento de Grupos de Trabajo</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

<?php include_partial('form', array('form' => $form)) ?>
