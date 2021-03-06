<?php use_helper('Security');  ?>	
<?php use_helper('Date');?>
<?php if($sf_request->getParameter('consejo')){
$redireccionGrupo = 'consejo='.$sf_request->getParameter('consejo');
}else{
$redireccionGrupo = '';
} ?>
<div class="mapa">
	  <strong>Consejos Territoriales</strong> > <a href="<?php echo url_for('documentacion_consejos_lista/index') ?>">Documentación</a> > <?php echo  $documentacion_consejo->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Documentación de Consejos Territoriales</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <a  class="nottit"><?php echo  $documentacion_consejo->getNombre() ?></a><br />
	  <?php echo $documentacion_consejo->getcontenido() ?>
	  <br />  
	  <span class="notfecha">
	  <?php
            if($resposable){
            include_partial('CarpetaDocumentos', array('valor'=>$documentacion_consejo));
            }elseif($documentacion_consejo->getConfidencial() != 1) {
             include_partial('CarpetaDocumentos', array('valor'=>$documentacion_consejo));
            }elseif($documentacion_consejo->getConfidencial() == 1){
             include_partial('CarpetaDocumentosConfidencial', array('valor'=>$documentacion_consejo));
            }
          ?>
	  </span><br />  
	  <?php if($documentacion_consejo->getUserIdCreador()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($documentacion_consejo->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($documentacion_consejo->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($documentacion_consejo->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($documentacion_consejo->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($documentacion_consejo->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($documentacion_consejo->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($documentacion_consejo->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($documentacion_consejo->getFechaPublicado())?></span><br />     
	  <?php endif;?> 
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_consejos_lista/editar?id='.$documentacion_consejo->getId().'&'.$redireccionGrupo) ?>';"/>
	 <?php endif;?> 
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_consejos_lista/index?'.$redireccionGrupo) ?>';"/>
	</div>
