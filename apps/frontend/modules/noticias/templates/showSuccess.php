<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('noticias/index') ?>">Noticias</a> &gt; <?php echo  $noticia->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="50%"><h1>Noticias</h1></td>
	    <td width="50%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<br clear="all" />
	<br clear="all" />
	<div class="noticias">
	  <?php if($noticia->getMasImagen() && $noticia->getImagen()):?>
	  <img src="<?php if ($noticia->getImagen()): ?>/uploads/noticias/images/<?php echo $noticia->getImagen()?><?php else: ?> /images/noimage.jpg<?php endif; ?>" class="notimg" alt="<?php echo  $noticia->getTitulo() ?>" />
	  <?php endif;?>
	  <span class="notfecha">Fecha: <?php echo date("d/m/Y", strtotime($noticia->getFecha())) ?></span><br />
	  <a class="nottit"><?php echo  $noticia->getTitulo() ?></a><br />
          <p class="notentrada" align="justify"><?php echo nl2br($noticia->getEntradilla()) ?></p>
	  <div class="ul_noticias"><?php echo $noticia->getContenido()?></div> 
	  <br clear="all" /> 
	  <?php if($noticia->getDocumento()):?>   
	  <a href="<?php echo url_for("/uploads/noticias/docs/".$noticia->getDocumento())?>" class="descargar-documento" target="_blank">Documento +</a>
	  <?php endif;?>
	  <br><br>
	  <?php if($noticia->getAutor()):?> 
	  <span class="notfecha">Autor / Medio: <?php echo $noticia->getAutor() ?></span><br />    
	  <?php endif ?>
	  <?php $roles = UsuarioRol::getRepository()->getRolesByUser($sf_user->getAttribute('userId'),1);
	   if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles)):?> 
	  <?php if($noticia->getFechaCaducidad()):?> 
	  <span class="notfecha">Fecha de caducidad: <?php echo date("d/m/Y", strtotime($noticia->getFechaCaducidad())) ?></span><br />     
	  <?php endif; ?>
	   <?php if($noticia->getUserIdCreador()):?>
	   <span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($noticia->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($noticia->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($noticia->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($noticia->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($noticia->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($noticia->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($noticia->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($noticia->getFechaPublicado())?></span><br />     
	  <?php endif;?> 
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