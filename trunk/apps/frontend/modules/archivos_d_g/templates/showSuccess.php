<?php
	use_helper('Security');
	use_helper('Date');
?>
<div class="mapa">
	  <strong>Grupos de Trabajo</strong> &gt; <a href="<?php echo url_for('archivos_d_g/index') ?>">Archivos</a> &gt; <?php echo  $archivo_dg->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Archivos de Grupos de Trabajo</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($archivo_dg->getFecha())) ?></span> <span class="notfecha">- Fecha de caducidad: <?php echo date("d/m/Y", strtotime($archivo_dg->getfecha_caducidad())) ?></span><br />     
	  <a href="#" class="nottit"><?php echo  $archivo_dg->getNombre() ?></a><br />
	  <?php echo nl2br($archivo_dg->getcontenido()) ?>      
	  <div class="clear"></div>
	  <?php if($archivo_dg->getArchivo()): ?>
	  <span class="notfecha">
	  	<a href="<?php echo url_for('/uploads/archivos_d_g/docs/'.$archivo_dg->getArchivo());?>" class="descargar-documento" target="_blank">
	  		Documento +
	  	</a>
	  </span><br />
	  <?php endif; ?>
	  <?php if($archivo_dg->getOwnerId()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($archivo_dg->getOwnerId()) ?> el d&iacute;a: <?php echo format_date($archivo_dg->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_d_g/editar?id='.$archivo_dg->getId()) ?>';"/>
	 <?php endif ;?> 
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_d_g/index') ?>';"/>
	</div>