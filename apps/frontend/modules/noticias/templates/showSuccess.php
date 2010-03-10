<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('noticias/index') ?>">Noticia</a> &gt; <?php echo  $noticia->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Noticia</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>

	<div class="noticias">
	  <img src="<?php if ($noticia->getimagen()): ?>/uploads/noticias/images/<?php echo $noticia->getimagen()?><?php else: ?> /images/noimage.jpg<?php endif; ?>" class="notimg" alt="<?php echo  $noticia->gettitulo() ?>" />
	  <span class="notfecha">Fecha: <?php echo date("d/m/Y", strtotime($noticia->getFecha())) ?></span><br />
	  <a class="nottit"><?php echo  $noticia->gettitulo() ?></a><br />
	  <p class="notentrada"><?php echo $noticia->getentradilla() ?></p>
	  <?php echo $noticia->getcontenido() ?>  
	  <?php if($noticia->getdocumento()):?>   
	  <a href="<?php echo url_for("/uploads/noticias/docs/".$noticia->getdocumento())?>" class="notentrada">Documento +</a> 
	  <?php endif;?>
	  <br><br><span class="notfecha">Autor / Medio: <?php echo $noticia->getAutor() ?></span><br />     
	  <span class="notfecha">Fecha de caducidad: <?php echo date("d/m/Y", strtotime($noticia->getfecha_caducidad())) ?></span><br />     
	   <?php if($noticia->getUserIdCreador()):?>
	   <span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($noticia->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($noticia->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($noticia->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($noticia->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($noticia->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($noticia->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($noticia->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($noticia->getFechaPublicado())?></span><br />     
	  <?php endif;?> 
	   <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('noticias/editar?id='.$noticia->getId()) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('noticias/index') ?>';"/>
	</div>