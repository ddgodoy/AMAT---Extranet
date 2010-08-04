<?php use_helper('Security'); ?>
<?php use_helper('Date');?>
<?php if($sf_request->getParameter('grupo')){
$redireccionGrupo = 'grupo='.$sf_request->getParameter('grupo');
}else{
$redireccionGrupo = '';
} ?>
<div class="mapa">
	  <strong>Grupos de Trabajo</strong> > <a href="<?php echo url_for('documenatcion_grupos_trabajo/index') ?>">Documentación</a> > <?php echo  $documentacion_grupo->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Documentación de Grupos de Trabajo</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <a  class="nottit"><?php echo  $documentacion_grupo->getNombre() ?></a><br />
	  <?php echo $documentacion_grupo->getcontenido() ?> 
	  <span class="notfecha">
	  <?php
            if($resposable){
            include_partial('CarpetaDocumentos', array('valor'=>$documentacion_grupo));
            }elseif($documentacion_grupo->getConfidencial() != 1) {
             include_partial('CarpetaDocumentos', array('valor'=>$documentacion_grupo));
            }elseif($documentacion_grupo->getConfidencial() == 1){
             include_partial('CarpetaDocumentosConfidencial', array('valor'=>$documentacion_grupo));
            }
          ?>
	  </span><br />  
	   <?php if($documentacion_grupo->getUserIdCreador()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($documentacion_grupo->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($documentacion_grupo->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($documentacion_grupo->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($documentacion_grupo->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($documentacion_grupo->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($documentacion_grupo->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($documentacion_grupo->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($documentacion_grupo->getFechaPublicado())?></span><br />     
	  <?php endif;?>      
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documenatcion_grupos_trabajo/index?'.$redireccionGrupo) ?>';"/>
	</div>
