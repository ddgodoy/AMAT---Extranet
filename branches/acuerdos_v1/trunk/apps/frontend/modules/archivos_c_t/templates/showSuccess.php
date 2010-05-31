<?php use_helper('Security');?>
<?php use_helper('Date');?>
 <?php if($sf_request->getParameter('archivo_c_t[documentacion_consejo_id]') && $sf_request->getParameter('consejo_territorial_id')): $redireccionGrupo = 'archivo_c_t[documentacion_consejo_id]='.$sf_request->getParameter('archivo_c_t[documentacion_consejo_id]').'&consejo_territorial_id='.$sf_request->getParameter('consejo_territorial_id'); else : $redireccionGrupo = ''; endif; ?>
<div class="mapa">
	  <strong>Consejos Territoriales</strong> &gt; <a href="<?php echo url_for('archivos_c_t/index') ?>">Archivos</a> &gt; <?php echo  $archivo_ct->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Archivos de Consejos Territoriales</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($archivo_ct->getFecha())) ?></span> <span class="notfecha">- Fecha de caducidad: <?php echo date("d/m/Y", strtotime($archivo_ct->getfecha_caducidad())) ?></span><br />     
	  <a  class="nottit"><?php echo  $archivo_ct->getNombre() ?></a><br />
	  <?php echo nl2br($archivo_ct->getcontenido()) ?> 
	  <?php if($archivo_ct->getArchivo()): ?>
          <span class="notfecha"><a href="<?php echo url_for('/uploads/archivos_c_t/docs/'.$archivo_ct->getArchivo());?>" class="descargar-documento" target="_blank">Documento +</a></span><br />
	  <?php endif; ?>
	  <?php if($archivo_ct->getOwnerId()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($archivo_ct->getOwnerId()) ?> el d&iacute;a: <?php echo format_date($archivo_ct->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_c_t/editar?id='.$archivo_ct->getId().'&'.$redireccionGrupo) ?>';"/>
	<?php endif; ?>
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_c_t/index?'.$redireccionGrupo) ?>';"/>
	</div>
