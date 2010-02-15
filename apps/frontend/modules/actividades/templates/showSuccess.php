<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Canal Corporativo</strong> &gt; Web Amat &gt; <a href="<?php echo url_for('actividades/index') ?>">Actividades</a> &gt; <?php echo  $actividad->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Actividades</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <img src="<?php if ($actividad->getimagen()): ?>/uploads/actividades/images/s_<?php echo $actividad->getimagen() ?> <?php else: ?> /images/noimage.jpg <?php endif; ?>" class="notimg" alt="<?php echo  $actividad->gettitulo() ?>" />
	  <a href="#" class="nottit"><?php echo  $actividad->gettitulo() ?></a><br />
	  <?php echo $actividad->getcontenido() ?> 
	   <?php if($actividad->getUserIdCreador()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($actividad->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($actividad->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($actividad->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($actividad->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($actividad->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($actividad->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($actividad->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($actividad->getFechaPublicado())?></span><br />     
	  <?php endif;?>      
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	  <?php if (validate_action('modificar')):?> 
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('actividades/editar?id='.$actividad->getId()) ?>';"/>
	  <?php endif;?>
	  <?php if (validate_action('baja')):?> 
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('actividades/index') ?>';"/>
	  <?php endif;?>
	</div>
