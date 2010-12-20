<?php
	use_helper('Javascript');
	use_helper('Security');
?>
<div class="mapa">
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('aplicaciones/index') ?>">Aplicaciones</a> &gt; 
	Actualizar Aplicaci&oacute;n Interna
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Actualizar Aplicaciones Internas</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>
<?php if ($error): ?><ul class="error_list"><li><?php echo $error ?></li></ul><?php endif; ?>
<form action="<?php echo url_for('aplicaciones/editar_internal') ?>" method="post" enctype="multipart/form-data">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="48%"><label>Los campos marcados con (*) son obligatorios</label></td>
				<td width="52%" align="right"></td>
			</tr>
		</tbody>
	</table>
	<br />
	<fieldset>
		<legend>Aplicaciones</legend>
		<table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="8%">Nombre *</td>
					<td width="72%" valign="middle"><input type="text" name="field_nombre" value="<?php echo $field_nombre ?>"/></td>
					<td width="30" align="right">
						<a href="<?php echo url_for('aplicaciones_rol/index?caja_busqueda='.$field_nombre) ?>" style="margin-right:7px;"/>Perfiles</a>
						<!--|<a href="<?php //echo url_for('aplicaciones/usuarios?id='.$id) ?>" style="margin-left:10px;"/>Usuarios</a>-->
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<div class="botonera" style="padding-top:10px;">
		<input type="submit" id="btn_action" class="boton" value="Guardar" name="btn_action"/>
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<input type="hidden" name="page" value="<?php echo $paginaActual ?>" />
		<input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('aplicaciones/index?page='.$paginaActual) ?>';"/>
	</div>
</form>