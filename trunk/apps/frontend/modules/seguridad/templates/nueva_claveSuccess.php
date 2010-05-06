<?php use_helper('Javascript') ?>

<?php include_partial('header') ?>
<?php include_partial('global/help') ?>

<div class="head">
  <div class="img1">
  	<?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
  	<h1>Extranet Sectorial AMAT</h1>
  </div>	
</div>

<div class="logueo">
	<div style="width:420px;margin-right:auto;margin-left:auto;">
		<?php echo $form['email']->renderError() ?>
		<?php echo $form['captcha']->renderError() ?>
		<?php if (!empty($renderErrorParticular)): ?><div class="mensajeSistema error"><?php echo $renderErrorParticular ?></div><?php endif; ?>
	</div>
<!--*-->
	<?php if (!empty($solicitudEnviada)): ?>
	<h2>La solicitud ha sido enviada</h2>
	<div class="logbox" style="background-image:none;">
		<div class="mensajeSistema ok" style="margin-bottom:15px;">
			Un mensaje ha sido enviado a su cuenta de correo con<br />detalles sobre c&oacute;mo obtener una nueva clave.<br /><br />Por favor, revise su buzón de correo para continuar con el proceso.
		</div>
		<input name="btn_volver" value="Volver al Inicio" class="boton" onclick="document.location='<?php echo url_for('inicio/index') ?>';" type="button">
		<br clear="all" />
	<?php else: ?>
<!--*-->
	<h2>Solicitud de Nueva Clave</h2>
        <div class="logbox" >
		<h1 style="padding-right:20px;text-align:left;line-height:normal">Ingrese su cuenta de correo de registro y los caracteres de la imagen</h1>
		<form action="<?php echo url_for('seguridad/enviar_solicitud') ?>" method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="0" cellspacing="5">
				<tbody>
					<tr>
						<td style="padding-top: 5px;" width="100%" align="right">
							<label><?php echo $form['email']->renderLabel('Cuenta de Correo') ?></label>
						</td>
						<td style="padding-top: 5px;"><?php echo $form['email'] ?></td>
					</tr>
					<tr>
						<td align="right">
							<label><?php echo $form['captcha']->renderLabel() ?></label>
						</td>
						<td align="left"><?php echo $form['captcha'] ?></td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top:20px;">
							<input name="btn_action3" value="Enviar Solicitud" class="boton" type="submit" style="margin-left:10px;">
							<input name="btn_volver" value="Cancelar" class="boton" onclick="document.location='<?php echo url_for('inicio/index') ?>';" type="button">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<script language="javascript" type="text/javascript">
			$('<?php echo $form['captcha']->renderId() ?>').value = '';
			$('<?php echo $form['email']->renderId() ?>').focus();
		</script>
<!--*-->
	<?php endif; ?>
	</div>
</div>
<div class="clear"></div>
</body>
</html>