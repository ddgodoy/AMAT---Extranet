<div class="mapa">
	<strong>Administraci&oacute;n </strong>&gt; <a href="<?php echo url_for('contenidos/index') ?>">Contenidos</a> &gt; Crear contenido
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Nuevo contenido</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>
<?php include_partial('form', array ('form'=>$form, 'pageActual'=>1)) ?>