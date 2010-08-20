<div class="mapa"><strong>Gestión de Iniciativas</strong> &gt; <a href="<?php echo url_for('categoria_iniciativa/index') ?>">Categorias de Iniciativas</a> &gt; Editar</div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Categorias de Iniciativas</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
<?php include_partial('form', array('form' => $form)) ?>
