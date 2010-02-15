<div class="mapa"><strong>Administraci&oacute;n</strong> &gt Perfil del Usuario: <?php echo $usuario->getNombre().' '.$usuario->getApellido()?></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td width="70%"><h1>Perfil del Usuario <?php echo $usuario->getNombre().' '.$usuario->getApellido()?></h1></td>
				<td width="5%" align="right">
					<a href="#">
						<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
					</a>
				</td>
			</tr>
		</tbody>
	</table>


<div >
	<?php if (count($arrayPeApliAcci) > 0) : ?>
	<?php $i=0; foreach ($arrayPeApliAcci as $aplicacion_rol): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
    <fieldset><label><?php echo $aplicacion_rol['perfil']?></label> 
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="listados">
		<tbody>
			<tr>
				<th width="23%">Aplicaci&oacute;n</th>
				<th width="7%" style="text-align:center;">Alta</th>
				<th width="7%" style="text-align:center;">Baja</th>
				<th width="7%" style="text-align:center;">Modificar</th>
				<th width="7%" style="text-align:center;">Listar</th>
				<th width="7%" style="text-align:center;">Publicar</th>
			</tr>
			<?php $i=0; foreach ($aplicacion_rol['apliacio'] as $aplicacion): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
			   <tr class="<?php echo $odd ?>">
				<td><?php echo $aplicacion->getAplicacion() ?></td>
				<td align="center"><?php echo ($aplicacion->getAccionAlta())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion->getAccionBaja())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion->getAccionModificar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion->getAccionListar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
				<td align="center"><?php echo ($aplicacion->getAccionPublicar())?image_tag('aceptada.png'):image_tag('rechazada.png') ?></td>
			</tr>
	       <?php endforeach; ?>			
		</tbody>
	</table>
	</fieldset>
	<?php endforeach; ?>	
	<?php else : ?>
			<div class="mensajeSistema comun">No hay Reglas registradas</div>
	<?php endif; ?>
	<div class="botonera" style="padding-top:10px;">
			<input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('usuarios/index') ?>';"/>
		</div>
</div>	
<!-- * -->
<div class="clear"></div>