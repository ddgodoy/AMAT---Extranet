<?php use_helper('Security'); ?>
<?php use_helper('Date');?>
<?php
    if(sfConfig::get('sf_environment') == 'dev'){
    if($sf_request->getParameter('documentacion_organismo[organismo_id]')):
    $redireccionGrupo = Organismo::getUrlOrganismos($sf_request->getParameter('documentacion_organismo[organismo_id]'));
    else:
    $redireccionGrupo = '';
    endif;
    }else{
    if($sf_request->getParameter('documentacion_organismo%5Borganismo_id%5D')):
    $redireccionGrupo = Organismo::getUrlOrganismos($sf_request->getParameter('documentacion_organismo%5Borganismo_id%5D'));
    else:
    $redireccionGrupo = '';
    endif;
    }
 ?>
<?php
    if($redireccionGrupo!=''){
    $getArchivo = explode('&',$redireccionGrupo );
    $getCategoria = explode('=', $getArchivo['0']);
    $getSubCategoria = explode('=', $getArchivo['1']);

    $redireccionArchivo = '&archivo_d_o[categoria_organismo_id]='.$getCategoria['1'].'&archivo_d_o[subcategoria_organismo_id]='.$getSubCategoria['1'];

    }else{
    $redireccionArchivo ='';
    }
?>
<div class="mapa">
	  <strong>Organismos</strong> > <a href="<?php echo url_for('documentacion_organismos/index') ?>">Documentación</a> > <?php echo  $documentacion_organismo->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Documentación de Organismos</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <span class="notfecha">Fecha de publicacion: <?php echo date("d/m/Y", strtotime($documentacion_organismo->getfecha_publicacion())) ?></span><br />     
	  <a  class="nottit"><?php echo  $documentacion_organismo->getNombre() ?></a><br />
	  <?php echo $documentacion_organismo->getcontenido()?>
          <br />
	  <span class="notfecha">
	  <?php
            if($resposable){
            include_partial('CarpetaDocumentos', array('valor'=>$documentacion_organismo, 'redireccionArchivo'=>$redireccionArchivo));
            }elseif($documentacion_organismo->getConfidencial() != 1) {
             include_partial('CarpetaDocumentos', array('valor'=>$documentacion_organismo, 'redireccionArchivo'=>$redireccionArchivo));
            }elseif($documentacion_organismo->getConfidencial() == 1){
             include_partial('CarpetaDocumentosConfidencial', array('valor'=>$documentacion_organismo, 'redireccionArchivo'=>$redireccionArchivo));
            }
          ?>
	  </span><br />  
	  <?php if($documentacion_organismo->getUserIdCreador()):?>
	   <br><span class="notfecha">Creado por: <?php echo Usuario::datosUsuario($documentacion_organismo->getUserIdCreador()) ?> el d&iacute;a: <?php echo format_date($documentacion_organismo->getCreatedAt())?></span><br /> 
	  <?php endif;?>
	  <?php if($documentacion_organismo->getUserIdModificado()):?> 
	   <span class="notfecha">Modificado por: <?php echo Usuario::datosUsuario($documentacion_organismo->getUserIdModificado()) ?> el d&iacute;a: <?php echo format_date($documentacion_organismo->getUpdatedAt())?></span><br />     
	  <?php endif;?>
	  <?php if($documentacion_organismo->getUserIdPublicado()):?> 
	   <span class="notfecha">Publicado por: <?php echo Usuario::datosUsuario($documentacion_organismo->getUserIdPublicado()) ?> el d&iacute;a: <?php echo format_date($documentacion_organismo->getFechaPublicado())?></span><br />     
	  <?php endif;?>      
	  <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
<?php if(validate_action('modificar')):?>
	<input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_organismos/editar?id='.$documentacion_organismo->getId().'&'.$redireccionGrupo) ?>';"/>
<?php endif;?>	
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_organismos/index?'.$redireccionGrupo) ?>';"/>
	</div>
