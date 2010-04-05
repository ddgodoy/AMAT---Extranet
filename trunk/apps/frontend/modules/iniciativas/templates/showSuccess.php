<?php use_helper('Security');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('iniciativas/index') ?>">Iniciativas Formativas</a> &gt; <?php echo  $iniciativa->getnombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Iniciativas Formativas</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($iniciativa->getFecha())) ?></span> <br />     
	  <a href="#" class="nottit"><?php echo  $iniciativa->getnombre() ?></a><br />
	  <?php if($iniciativa->getCategoriaIniciativaId()):?>
	  <span class="notfecha">Categor&iacute;a: <?php echo CategoriaIniciativa::getRepository()->findOneById($iniciativa->getCategoriaIniciativaId())->getNombre()?></span> <br />   
	  <?php endif;?>
	  <?php if($iniciativa->getSubcategoriaIniciativaId()):?>
	  <span class="notfecha">Sub-categor&iacute;a: <?php echo SubCategoriaIniciativa::getRepository()->findOneById($iniciativa->getSubcategoriaIniciativaId())->getNombre()?></span> <br />   
	  <?php endif;?>
	  <?php echo nl2br($iniciativa->getcontenido()) ?>      
	  <div class="clear"></div>
	  <?php if ($iniciativa->getDocumento()): ?>
	   <a href="<?php echo url_for("/uploads/iniciativas/docs/".$iniciativa->getDocumento())?>" class="descargar-documento" target="_blank">Documento +</a>
	  <?php endif; ?>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('iniciativas/editar?id='.$iniciativa->getId()) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('iniciativas/index') ?>';"/>
	</div>
