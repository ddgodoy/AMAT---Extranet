<?php use_helper('Security', 'CifradoSimetrico');?>
<script language="javascript" type="text/javascript">
function checkActualizarPerfil() {
	var nombre  = $('usu_nombre');
	var apellido= $('usu_apellido');
	var email   = $('usu_email');
	var clave   = $('usu_clave');
	var repetir = $('usu_repetir');
	
	if (nombre.value == '')  {alert('Complete el Nombre');  nombre.focus();  return false;}
	if (apellido.value == ''){alert('Complete el Apellido');apellido.focus();return false;}
	if (email.value == '')   {alert('Complete el Email');   email.focus();   return false;}
	
	if (clave.value != '') {
		if (repetir.value == '') {
			alert('Debe repetir la Clave'); repetir.focus(); return false;
		} else {
			if (clave.value != repetir.value) {
				alert('Las Claves no coinciden'); clave.focus(); return false;
	}}}
	return true;
}
</script>
<div class="mapa"><strong>Perfil de Usuario </strong></div>
<?php if ($sf_user->hasFlash('updatePerfil')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('updatePerfil') ?></div><?php endif; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="95%"><h1>Mis Datos</h1></td>
    <td width="5%" align="right"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></td>
  </tr>
</table>
<div class="leftside" style="width: 500px;">
<form action="<?php echo url_for('usuarios/perfil') ?>" method="post" enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="5">
		<tbody>
		<tr>
            <td style="padding-top: 5px;" width="90"><label>Nombre *</label></td>
            <td style="padding-top: 5px;"><input name="usu_nombre" id="usu_nombre" value="<?php echo $usuNombre ?>" class="form_input" style="width: 300px;" type="text" /></td>
            </tr>
                    <tr>
                            <td style="padding-top: 5px;" width="90"><label>Apellido *</label></td>
                            <td style="padding-top: 5px;">
                                    <?php echo input_tag('usu_apellido', $usuApellido, array('class'=>'form_input', 'style'=>'width:300px;')) ?>
                            </td>
                    </tr>
                    <tr>
                            <td style="padding-top: 5px;" width="90"><label>Cuenta de correo *</label></td>
                            <td style="padding-top: 5px;">
                                    <?php echo input_tag('usu_email', $usuEmail, array('class'=>'form_input', 'style'=>'width:300px;')) ?>
                            </td>
                    </tr>
                    <tr>
                            <td style="padding-top: 5px;" width="90"><label>Teléfono </label></td>
                            <td style="padding-top: 5px;">
                                    <?php echo input_tag('usu_telefono', $usuTelefono, array('class'=>'form_input', 'style'=>'width:300px;')) ?>
                            </td>
                    </tr>
                    <tr>
                            <td colspan="2" style="padding-top:10px;" align="center">
                                    <fieldset>
                                            <legend>Actualizar Contraseña</legend>
                                            <table bgcolor="#dfe1e1" cellpadding="5">
                                                    <tr><td><label>Contraseña</label></td><td>****************</td></tr>
                                                    <tr>
                                                            <td><label>Nueva Contraseña</label></td>
                                                            <td><?php echo input_password_tag('usu_clave', '', array('class'=>'form_input')) ?></td>
                                                    </tr>
                                                    <tr>
                                                            <td><label>Repetir Contraseña</label></td>
                                                            <td><?php echo input_password_tag('usu_repetir', '', array('class'=>'form_input')) ?></td>
                                                    </tr>
                                            </table>
                                    </fieldset>
                            </td>
                    </tr>
                    <?php if($aplicacion): ?>
                    <?php foreach ($aplicacion AS $K =>$apli): ?>
                    <?php
                    if($apli->getAplicacionExterna()->getRequiere()==1):
                    $usu =  $apli->getLogin()?decifrado($apli->getLogin()):'';
                    $pass = $apli->getPass()?decifrado($apli->getPass()):'' ;
                    ?>
                    <tr>
                            <td colspan="2" style="padding-top:10px;" align="center">
                                    <fieldset>
                                            <legend>Datos acceso aplicacion <?php echo $apli->getAplicacionExterna()->getNombre() ?></legend>
                                            <table bgcolor="#dfe1e1" cellpadding="5">
                                                    <?php echo input_hidden_tag('aplicacion_externa[]', $apli->getAplicacionExternaId()); ?>
                                                    <!--<tr><td><label>Contraseña</label></td><td>****************</td></tr>-->
                                                    <tr>
                                                        <td><img align="middle" src="<?php echo '/uploads/aplicaciones_externas/'.$apli->getAplicacionExterna()->getImagen() ?>" title="<?php echo $apli->getAplicacionExterna()->getNombre() ?>" border="0"/></td>
                                                            <td><label>Usuario</label></td>
                                                            <td><?php echo input_tag('usu_clave_apli_'.$apli->getAplicacionExternaId(), $usu, array('class'=>'form_input')) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td><label>Contraseña</label></td>
                                                        <td><?php echo input_password_tag('pass_clave_apli_'.$apli->getAplicacionExternaId(), $pass, array('class'=>'form_input')) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td align="right">
                                                            <?php if($usu != '' && $pass != '' ): ?>
                                                            <input name="btn_action" value="Verificar acceso" class="boton" type="button" style="margin-left:10px;" onclick="Confirmar_acceso('<?php echo $apli->getAplicacionExterna()->getUrl(); ?>','<?php echo $apli->getLogin(); ?>','<?php echo $apli->getPass(); ?>')">
                                                            <?php endif; ?>
                                                       </td>
                                                    </tr>
                                            </table>
                                    </fieldset>
                            </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <tr>
                            <td colspan="2" style="padding-top:20px;">
                                    <input name="btn_action" value="Actualizar" class="boton" type="submit" style="margin-left:10px;" onclick="return checkActualizarPerfil();">
                                    <input name="btn_volver" value="Cancelar" class="boton" onclick="document.location='<?php echo url_for('inicio/index') ?>';" type="button">
                            </td>
                    </tr>
		</tbody>
	</table>
</form>
</div>
<div class="rightside">
<table>
    <tr>
         <td colspan="2" rowspan="6" align="center" valign="top"><fieldset style="margin:0px 10px;">
                <legend>Organización a la que pertenece</legend>
                    <table width="100%"  cellpadding="5">
                       <?php if($mutuas):?><tr><td bgcolor="#dfe1e1" width="100%"><label>Mutua:</label><?php  echo '<tr><td><label>'.$mutuas.'</label></td></tr>';?></td></tr><?php endif;?>
                       <?php if(count($grupos) > 0):?><tr><td bgcolor="#dfe1e1" width="100%"><label>Grupos de Trabajo:</label><?php foreach ($grupos AS $i=>$name){ echo '<tr><td><label>'.$name.'</label></td></tr>';}?></td></tr><?php endif;?>
                      <?php if(count($consejo) > 0):?><tr><td bgcolor="#dfe1e1" width="100%"><label>Consejos Territoriales:</label><?php foreach ($consejo AS $i=>$name){ echo '<tr><td><label>'.$name.'</label></td></tr>';}?></td></tr><?php endif;?>
                    </table>
              </fieldset>
         </td>
     </tr>
</table>
</div>
<div class="clear"></div>