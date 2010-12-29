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
    <?php if(!empty ($editar)):?>
    <?php
         $arrayData = array();
         $urlExcepcion = 'usuarios/excepcion?usuario='.$form->getObject()->getId();
         $ExcepcionByNAme = Rol::getRepository()->getAllRol('aplication_'.$form->getObject()->getId());
         foreach ($ExcepcionByNAme AS $v){
           $arrayData['id'] = $v->getId();
         }
        if(!empty ($arrayData['id'])){
          $aplicacion_rol_list = AplicacionRol::getRepository()->getAplicacionByRol($arrayData['id']);
          $urlExcepcion.= '&excepcion='.$arrayData['id'];
        }

    ?>
    <div>
        <fieldset style="width: 925px;">
            <legend>Excepci&oacute;n</legend>
            <div style=" float: right;"><input type="button" id="btn_action" class="boton" value="Crear nueva Excepci&oacute;n" onclick="javascript:location.href='<?php echo url_for($urlExcepcion) ?>';" name="btn_action"/></div>
             <?php if(!empty ($aplicacion_rol_list) && count($aplicacion_rol_list)>0 ): ?>
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
                    <tbody>
                            <tr>
                                    <th width="23%">Aplicaci&oacute;n</th>
                                    <th width="7%" style="text-align:center;">Alta</th>
                                    <th width="7%" style="text-align:center;">Baja</th>
                                    <th width="7%" style="text-align:center;">Modificar</th>
                                    <th width="7%" style="text-align:center;">Listar</th>
                                    <th width="7%" style="text-align:center;">Publicar</th>
                                    <th width="4%"></th>
                                    <th width="4%"></th>
                            </tr>
                     <?php $i=0; foreach ($aplicacion_rol_list as $aplicacion_rol): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
                            <tr class="<?php echo $odd ?>">
                                    <td><?php echo $aplicacion_rol->getAplicacion() ?></td>
                                    <td align="center"><?php echo ($aplicacion_rol->getAccionAlta())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
                                    <td align="center"><?php echo ($aplicacion_rol->getAccionBaja())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
                                    <td align="center"><?php echo ($aplicacion_rol->getAccionModificar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
                                    <td align="center"><?php echo ($aplicacion_rol->getAccionListar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
                                    <td align="center"><?php echo ($aplicacion_rol->getAccionPublicar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
                                    <td align="center">
                                    <?php if(validate_action('modificar')):?>
                                            <a href="<?php echo url_for('usuarios/excepcion?usuario='.$form->getObject()->getId().'&id='.$aplicacion_rol->getId()) ?>"><?php echo image_tag('edit.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a>
                                    <?php endif;?>
                                    </td>
                                    <td align="center">
                                    <?php if(validate_action('baja')):?>
                                            <?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'usuarios/deletexc?id='.$aplicacion_rol->getId().'&usuario='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar esta regla "' . $aplicacion_rol->getRol() . '"?')) ?>
                                    <?php endif;?>
                                    </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
            </table>
         <?php endif;?>
        </fieldset>
    </div>
    <?php endif; ?>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
			<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
	<?php if($form->getObject()->isNew()):?>		
			<input type="submit" id="btn_enviar_email" class="boton" value="Guardar y Enviar Email" name="btn_enviar_email"/>
	<?php endif;?>		
	<?php endif; ?>		
			<input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('usuarios/index?page='.$pageActual) ?>';"/>
		</div>
    <?php echo $form->renderHiddenFields() ?>
</form>