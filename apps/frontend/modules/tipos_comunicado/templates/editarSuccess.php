
<div class="mapa"><strong>Comunicados</strong> &gt; <a href="<?php echo url_for('tipos_comunicado/index') ?>">Tipos</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Editar tipo de comunicado</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

<?php include_partial('form', array('form' => $form)) ?>
