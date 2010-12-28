<?php use_helper('Security');?>
	<div class="mapa">
	  <strong>Administraci&oacute;n </strong> <a href="<?php echo url_for('contenidos/index') ?>">&gt; <?php echo $aplicacion->getNombre();?></a> 
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1><?php echo $aplicacion->getNombre();?></h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados"></div>
	<div class="noticias">	  
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($aplicacion->getCreatedAt())) ?></span> <br />     
	  <?php echo $aplicacion->getDescripcion() ?>      
	  <div class="clear"></div>
	 </div>
	 <br clear="all" />
	
	<div class="botonera">
	<?php if (validate_action('modificar')): ?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('contenidos/editar?id='.$aplicacion->getId()) ?>';"/>
	<?php endif;?>  
	<?php if (validate_action('listar')): ?>
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('contenidos/index') ?>';"/>
	<?php endif; ?> 
	</div>