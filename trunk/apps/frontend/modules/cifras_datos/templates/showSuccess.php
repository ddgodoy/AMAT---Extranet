<?php use_helper('Security') ?>
<?php use_helper('Date');?>

<script type="text/javascript">
<!--
function confirmation(link) {
	var answer = confirm("Desea borrar este registro?")
	if (answer){
	//	alert("Bye bye!")
		window.location = link;
	}
}
//-->
</script>

    <div class="mapa">
	  <strong>Canal Corporativo</strong> &gt; Web Amat &gt; <a href="<?php echo url_for('cifras_datos/index') ?>">Cifras y Datos</a> &gt; <?php echo  $cifra_dato->gettitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Cifras y Datos</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	
	<?php // agregar esta linea para notificar las modificaciones en show ?>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>
	
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <img src="<?php if ($cifra_dato->getimagen()): ?>/uploads/cifras_datos/images/<?php echo $cifra_dato->getimagen() ?> <?php else: ?> /images/noimage.jpg <?php endif; ?>" class="notimg" alt="<?php echo  $cifra_dato->gettitulo() ?>" />

	  <a href="#" class="nottit"><?php echo  $cifra_dato->gettitulo() ?></a><br />
	  <?php echo $cifra_dato->getcontenido() ?>   
	   <?php if($cifra_dato->getdocumento()):?>   
	  <a href="<?php echo url_for("/uploads/cifras_datos/docs/".$cifra_dato->getdocumento())?>" class="notfecha">Documento +</a> 
	  <?php endif;?>   
	  <?php if($cifra_dato->getUserIdCreador()):?>
	  <br> <span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($cifra_dato->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($cifra_dato->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($cifra_dato->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($cifra_dato->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($cifra_dato->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($cifra_dato->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($cifra_dato->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($cifra_dato->getFechaPublicado())?></span><br />     
	  <?php endif;?> 
	  <div class="clear"></div>
	  
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('cifras_datos/index') ?>';"/>
	  <?php if (validate_action('modificar')):?> 
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('cifras_datos/editar?id='.$cifra_dato->getId()) ?>';"/>
	  <?php endif; ?>
	  <?php if (validate_action('baja')):?>          	
      <!--<input type="button" id="boton_cancel" class="boton" value="Borrar" name="boton_cancel" onclick="document.location='<?php //echo url_for('cifras_datos/delete?id='.$cifra_dato->getId()) ?>';"/>-->
      <?php //echo link_to('<button>Delete</button>', 'cifras_datos/delete?id='.$valor->getId(), array('method'=>'delete','confirm'=>'Confirma la eliminaci&oacute;n del registro?')) ?>
	  <?php //echo link_to(image_tag('borrar.png', array('title'=>'Borrar','alt'=>'Borrar','width'=>'20','height'=>'20','border'=>'0')),'state/delete?id='.$form->getObject()->getId(),array('method' => 'delete', 'confirm' => 'Are you sure?')); ?>
<!--echo link_to('<button>Delete</button>', 'state/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?'));-->
      <input type="button" id="boton_cancel" class="boton" value="Borrar" name="boton_cancel" onclick="confirmation('<?php echo url_for('cifras_datos/delete?id='.$cifra_dato->getId()) ?>');"/>
      <?php endif; ?>
      <?php if (validate_action('publicar') && $cifra_dato->getEstado()!='publicado'):?>
      <input type="button" id="boton_cancel" class="boton" value="Publicar" name="boton_cancel" onclick="document.location='<?php echo url_for('cifras_datos/publicar?id='.$cifra_dato->getId()) ?>';"/>
      <?php endif; ?>
	  
	</div>
