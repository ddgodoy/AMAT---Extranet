<div class="mapa">
	<!--<strong><?php //echo __('Administraci&oacute;n') ?> </strong>&gt;-->
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('categoria_asunto/index') ?>">Cuenta de Correo de Contacto</a> &gt; 
	Crear Cuenta de Correo
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Nueva Cuenta de Correo de Contacto</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>

<?php include_partial('form', array ('form'=>$form, 'pageActual'=>1)) ?>