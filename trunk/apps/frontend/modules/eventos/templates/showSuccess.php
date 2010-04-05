<?php use_helper('Security');?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('eventos/index') ?>">Eventos</a> &gt;  <?php echo  $evento->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Eventos</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <?php if($evento->getMasImagen() && $evento->getImagen()):?>
	  <img src="<?php if ($evento->getimagen()): ?>/uploads/eventos/images/<?php echo $evento->getimagen() ?> <?php else: ?> /images/noimage.jpg <?php endif; ?>" class="notimg" alt="<?php echo  $evento->gettitulo() ?>" />
	  <?php endif;?>
	  <a  class="nottit"><?php echo  $evento->gettitulo() ?> </a><br />
	  <p class="notentrada"><?php echo $evento->getdescripcion() ?></p>
	  <?php echo nl2br($evento->getmas_info()) ?>      
	  <div class="clear"></div>
	   <?php if($evento->getdocumento()):?>   
	  <a href="<?php echo url_for("/uploads/eventos/docs/".$evento->getdocumento())?>" class="descargar-documento" target="_blank">Documento +</a>
	  <?php endif;?>
	   <div class="clear"></div>
	   <br clear="all">
	   <?php $roles = UsuarioRol::getRepository()->getRolesByUser($sf_user->getAttribute('userId'),1);
	   if(Common::array_in_array(array('1'=>'1', '2'=>'2'), $roles)):?> 
	  <?php if($evento->getUserIdCreador()):?>
	   <span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($evento->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($evento->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($evento->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($evento->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($evento->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($evento->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($evento->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($evento->getFechaPublicado())?></span><br />     
	  <?php endif;?> 
	  <?php endif;?> 
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?> 
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('eventos/editar?id='.$evento->getId()) ?>';"/>
	<?php endif;?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('eventos/index') ?>';"/>
	</div>
