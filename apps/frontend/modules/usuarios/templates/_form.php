<?php
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);

	use_javascript('/sfFormExtraPlugin/js/double_list.js');
	use_helper('Security');
?>
<?php if ($sf_user->hasFlash('login_repetido')): ?><div class="mensajeSistema error"><?php echo $sf_user->getFlash('login_repetido') ?></div><?php endif; ?>
<?php
	echo $form['nombre']->renderError();
	echo $form['apellido']->renderError();
	echo $form['email']->renderError();
	echo $form['mutua_id']->renderError();
	echo $form['roles_list']->renderError();
	echo $form['login']->renderError();
	echo $form['password']->renderError();
	echo $form['repassword']->renderError();
	echo $form['grupos_trabajo_list']->renderError();
	echo $form['consejos_territoriales_list']->renderError();
	echo $form['aplicacion_externas_list']->renderError();
	echo $form['activo']->renderError();
	
	$accionForm = $form->getObject()->isNew() ? 'create' : 'update?id='.$form->getObject()->getId();
?>
<form action="<?php echo url_for('usuarios/'.$accionForm) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>
    <fieldset>
      <legend>Informaci&oacute;n General</legend>
      <ul class="campos">
	      <li><label>Nombre: </label><?php echo $form['nombre'] ?></li>
	      <li><label>Apellido: </label><?php echo $form['apellido'] ?></li>
	      <li><label>Mutua: </label><?php echo $form['mutua_id'] ?></li>
	      <li><label>Teléfono: </label><?php echo $form['telefono'] ?></li>
	      <li><label>Cuenta de correo: </label><?php echo $form['email'] ?></li>
	      <li><label>Activo: </label><?php echo $form['activo'] ?></li>
      </ul>
    </fieldset>
     <?php if(empty($editar)):?>
    <fieldset>
      <legend>Informaci&oacute;n de Acceso</legend>
      <ul class="campos">
        <li><label>Usuario: </label><?php echo $form['login'] ?></li>
        <li><label style="margin-left:4px;"><?php echo $form['password']->renderLabel() ?></label><?php echo $form['password'] ?></li>
        <li><label style="margin-left:4px;"><?php echo $form['repassword']->renderLabel() ?> </label><?php echo $form['repassword'] ?></li>
      </ul>
    </fieldset>
    <?php endif;?>
    <div class="clear"></div>
    <fieldset style="float:left; margin-right:10px;width:445px;">
      <legend>Grupos de Trabajo</legend><br /><?php echo $form['grupos_trabajo_list'] ?>
    </fieldset>
    <fieldset style="float:left; margin-right:10px;width:445px;">
      <legend>Consejos Territoriales</legend><br />
      <span style="float:left"><?php echo $form['consejos_territoriales_list'] ?>
      </span>
    </fieldset>
    <fieldset style="float:left; margin-right:10px;width:445px;">
      <legend>Perfiles</legend><br />
      <span style="float:left"><?php echo $form['roles_list'] ?></span>
    </fieldset>
     <fieldset style="float:left; margin-right:10px;width:445px;">
      <legend>Aplicaciones Externas</legend><br />
      <span style="float:left"><?php echo $form['aplicacion_externas_list'] ?>
      </span>
    </fieldset>
    <div class="clear"></div>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
			<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php endif; ?>		
			<input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('usuarios/index?page='.$pageActual) ?>';"/>
		</div>
    <?php echo $form->renderHiddenFields() ?>
</form>