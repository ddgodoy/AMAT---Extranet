<?php use_helper('Security') ?>
<?php use_helper('Date');?>
   <div class="mapa">
	  <strong>Canal Corporativo</strong> &gt; Web Amat &gt; <a href="<?php echo url_for('publicaciones/index') ?>">Publicaciones</a> &gt; <?php echo  $publicacion->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Publicaciones</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <img src="<?php if ($publicacion->getImagen()): ?>/uploads/publicaciones/images/<?php echo $publicacion->getImagen() ?> <?php else: ?> /images/noimage.jpg <?php endif; ?>" class="notimg" alt="<?php echo  $publicacion->getTitulo() ?>" />
	  <a href="#" class="nottit"><?php echo  $publicacion->getTitulo() ?></a><br />
	  <?php echo $publicacion->getcontenido() ?>     
	   <?php if($publicacion->getUserIdCreador()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($publicacion->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($publicacion->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($publicacion->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($publicacion->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($publicacion->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($publicacion->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($publicacion->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($publicacion->getFechaPublicado())?></span><br />     
	  <?php endif;?>  
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	 <?php if (validate_action('modificar')):?> 
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('publicaciones/editar?id='.$publicacion->getId()) ?>';"/>
	 <?php endif; ?> 
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('publicaciones/index') ?>';"/>
	</div>
