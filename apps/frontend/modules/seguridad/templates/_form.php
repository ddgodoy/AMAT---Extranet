<?php
	use_helper('Javascript');
	
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
?>
<div class="logueo">
	<div style="width:420px;margin-right:auto;margin-left:auto;">
		<?php
			echo $form['login']->renderError();
			echo $form['password']->renderError();
		?>
		<?php if ($sf_user->getFlash('error')): ?>
			<div class="mensajeSistema error"><?php echo $sf_user->getFlash('error') ?></div>
		<?php endif; ?>
	</div>
	<h2>Bienvenido a la Extranet Sectorial</h2>
	<div class="logbox">
		<h1>
			Introduzca su Usuario y Contrase&ntilde;a
		</h1>
		<form action="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/seguridad/process' ?>" method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="0" cellspacing="5">
				<tbody>
					<tr>
						<td style="padding-top: 5px;" width="70" align="right"><label>Usuario*</label></td>
						<td style="padding-top: 5px;"><?php echo $form['login'] ?></td>
					</tr>
					<tr>
						<td style="padding-top: 5px;" width="70" align="right"><label>Contraseña*</label></td>
						<td style="padding-top: 5px;"><?php echo $form['password'] ?></td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top: 5px;">
							<a href="<?php echo url_for('seguridad/nueva_clave') ?>">He olvidado mi Contraseña</a>
							<input name="btn_action3" value="Aceptar" class="boton" type="submit">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<?php echo javascript_tag("Field.activate('".$form['login']->renderId()."');") ?>

<div class="clear"></div>