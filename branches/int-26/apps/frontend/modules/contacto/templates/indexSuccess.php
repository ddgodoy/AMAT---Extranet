<div class="mapa"><strong>Contacto</strong></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="95%"><h1>Formulario de Contacto</h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>

	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>
	<?php if (!empty($mensajeError)): ?><div class="mensajeSistema error"><?php echo $mensajeError ?></div><?php endif; ?>

	<?php echo $form['tema']->renderError() ?>
	<?php echo $form['asunto']->renderError() ?>

	<div class="mapa">
		<form action="<?php echo url_for('contacto/process') ?>" method="post" enctype="multipart/form-data">
		<table width="80%" cellspacing="0" cellpadding="0" border="0" >
			<tbody>
			    <br clear="all">
				<tr>
					<td valign="top" align="right"><?php echo $form['tema']->renderLabel('Categoria') ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><?php echo $form['tema'] ?></td>
				</tr>
				<tr>
				<td><br clear="all"></td>
				</tr>
				<tr>
					<td valign="top" align="right"><?php echo $form['asunto']->renderLabel() ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><?php echo $form['asunto'] ?></td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input type="submit" value="Enviar" class="boton"/>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
<div class="clear"></div>