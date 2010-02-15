<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('circulares/index') ?>">Circulares</a> &gt; <?php echo  $circular->getNOmbre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Circulares</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>

	<div class="noticias">
	  <p class="notentrada"><?php echo  $circular->getNombre() ?></p><br />
	  <?php echo $circular->getContenido() ?>  
	  <?php if($circular->getdocumento()):?>   
	  <a href="<?php echo url_for("/uploads/circulares/docs/".$circular->getDocumento())?>" class="descargar-documento">Documento +</a> 
	  <?php endif;?>
	  <br><br>     
	   <span class="notfecha">Creado el d&iacute;a: <?php echo format_date($circular->getCreatedAt())?></span><br /> 
	   <span class="notfecha">Modificado el d&iacute;a: <?php echo format_date($circular->getUpdatedAt())?></span><br />     
	   <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('circulares/editar?id='.$circular->getId()) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('circulares/index') ?>';"/>
	</div>