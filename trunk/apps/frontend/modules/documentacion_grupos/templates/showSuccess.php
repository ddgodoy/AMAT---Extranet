<?php use_helper('Security'); ?>
<?php use_helper('Date');?>
<?php if($sf_request->getParameter('grupo')){
$redireccionGrupo = 'grupo='.$sf_request->getParameter('grupo');
}else{
$redireccionGrupo = '';
} ?>
<div class="mapa">
	  <strong>Grupos de Trabajo</strong> > <a href="<?php echo url_for('documentacion_grupos/index') ?>">Documentación</a> > <?php echo  $documentacion_grupo->getNombre() ?>
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
			if (validate_action('listar','archivos_d_g')&& $documentacion_grupo->getEstado() == 'publicado') {
				echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getRepository()->getAllByDocumentacion($documentacion_grupo->getId())->count().' Archivo/s')), 'archivos_d_g/index?archivo_d_g[documentacion_grupo_id]='.$documentacion_grupo->getId().'&grupo_trabajo_id='.$documentacion_grupo->getGrupoTrabajoId(), array('method' => 'post'));
			}
                        elseif($sf_user->getAttribute('userId')== $documentacion_grupo->getUserIdCreador()){
                               echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getRepository()->getAllByDocumentacion($documentacion_grupo->getId())->count().' Archivo/s')), 'archivos_d_g/index?archivo_d_g[documentacion_grupo_id]='.$documentacion_grupo->getId().'&grupo_trabajo_id='.$documentacion_grupo->getGrupoTrabajoId(), array('method' => 'post'));
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
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_grupos/editar?id='.$documentacion_grupo->getId().'&'.$redireccionGrupo) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('documentacion_grupos/index?'.$redireccionGrupo) ?>';"/>
	</div>
