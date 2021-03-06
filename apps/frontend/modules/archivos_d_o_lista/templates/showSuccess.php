<?php use_helper('Security');?>
<?php use_helper('Date');?>
<?php
$redireccionGrupo = '';
if(sfConfig::get('sf_environment') == 'dev'){
if($sf_request->getParameter('archivo_d_o[documentacion_organismo_id]')){
$redireccionGrupo = 'archivo_d_o[documentacion_organismo_id]='.
                    $sf_request->getParameter('archivo_d_o[documentacion_organismo_id]').
                    '&archivo_d_o[organismo_id]='.$sf_request->getParameter('archivo_d_o[organismo_id]'); }
}else{
if($sf_request->getParameter('archivo_d_o%5Bdocumentacion_organismo_id%5D')){
$redireccionGrupo = 'archivo_d_o[documentacion_organismo_id]='.
                    $sf_request->getParameter('archivo_d_o%5Bdocumentacion_organismo_id%5D').
                    '&archivo_d_o[organismo_id]='.$sf_request->getParameter('archivo_d_o%5Borganismo_id%5D'); }
}?>
<div class="mapa">
	  <strong>Organismos</strong> &gt; <a href="<?php echo url_for('archivos_d_o_lista/index') ?>">Archivos</a> &gt; <?php echo  $archivo_do->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Archivos de Organismos</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<?php if ($sf_user->hasFlash('notice')): ?><div class="mensajeSistema ok"><?php echo $sf_user->getFlash('notice') ?></div><?php endif; ?>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($archivo_do->getFecha())) ?></span> <span class="notfecha">- Fecha de caducidad: <?php echo date("d/m/Y", strtotime($archivo_do->getfecha_caducidad())) ?></span><br />     
	  <a  class="nottit"><?php echo  $archivo_do->getNombre() ?></a><br />
          <br clear="all" /> 
	  <?php echo nl2br($archivo_do->getcontenido()) ?>
          <?php if($archivo_do->getArchivo()): ?>
	  <span class="notfecha"><a href="<?php echo url_for('/uploads/archivos_d_o/docs/'.$archivo_do->getArchivo());?>" class="descargar-documento" target="_blank">Documento +</a></span><br />
          <?php endif; ?>
	  <?php if($archivo_do->getOwnerId()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($archivo_do->getOwnerId()) ?> el d&iacute;a: <?php echo format_date($archivo_do->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <div class="clear"></div>
	  
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('archivos_d_o_lista/index?'.$redireccionGrupo) ?>';"/>
	</div>
