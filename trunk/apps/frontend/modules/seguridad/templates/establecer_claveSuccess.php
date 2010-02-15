<?php use_helper('Javascript') ?>

<?php include_partial('header') ?>
<?php include_partial('global/help') ?>

<div class="head">
  <div class="img1">
  	<?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
  	<h1>Extranet de Asociados AMAT</h1>
  </div>	
</div>

<div class="logueo">
	<div style="width:420px;margin-right:auto;margin-left:auto;">
		<?php echo $form['password']->renderError() ?>
		<?php echo $form['repassword']->renderError() ?>
	</div>

	<?php if (!empty($cambioClaveExitoso)): ?>
		<h2>Registro exitoso de Nueva Clave</h2>
		<div class="logbox" style="background-image:none;">
		<div class="mensajeSistema ok" style="margin-bottom:15px;">
			Su nueva clave ha sido registrada exitosamente.<br /><br />
			Ya puede ingresar sus datos en la<br />
			pantalla inicial y comenzar su sesi&oacute;n.
		</div>
		<input name="btn_volver" value="Volver al Inicio" class="boton" onclick="document.location='<?php echo url_for('inicio/index') ?>';" type="button">
		<br clear="all" />
	<?php else: ?>
	<h2>Registre su Nueva Clave</h2>
	<div class="logbox">
		<h1>Ingrese la nueva informaci&oacute;n para completar el proceso</h1>
		<form action="<?php echo url_for('seguridad/update_clave') ?>" method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="0" cellspacing="5">
				<tbody>
					<tr>
						<td style="padding-top: 5px;" width="90" align="right">
							<label><?php echo $form['password']->renderLabel() ?></label>
						</td>
						<td style="padding-top: 5px;"><?php echo $form['password'] ?></td>
					</tr>
					<tr>
						<td align="right">
							<label><?php echo $form['repassword']->renderLabel() ?></label>
						</td>
						<td align="left"><?php echo $form['repassword'] ?></td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top:20px;">
							<input name="btn_action3" value="Registrar" class="boton" type="submit" style="margin-left:10px;">
							<input name="btn_volver" value="Cancelar" class="boton" onclick="document.location='<?php echo url_for('inicio/index') ?>';" type="button">
							<input type="hidden" name="key" value="<?php echo $auxCodigo ?>"/>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	<?php endif; ?>
	</div>
</div>

<?php echo javascript_tag("Field.activate('".$form['password']->renderId()."');") ?>

<div class="clear"></div>
</body>
</html>