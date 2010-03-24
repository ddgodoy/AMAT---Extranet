<?php use_helper('Security');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('normativas/index') ?>">Normativas</a> &gt; <?php echo  $normativa->getnombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Normativas</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($normativa->getFecha())) ?></span> <br />     
	  <a class="nottit"><?php echo  $normativa->getnombre() ?></a><br />
	  <!--<?php //if($normativa->getCategoriaNormativaId()):?>
	   <span class="notfecha">Categor&iacute;a: <?php // echo CategoriaNormativa::getRepository()->findOneById($normativa->getCategoriaNormativaId())->getNombre()?></span> <br />   
	  <?php //endif;?>
	  <?php //if($normativa->getSubcategoriaNormativaUnoId()):?> 
	  <span class="notfecha">Sub-categor&iacute;a (nivel 1): <?php //echo SubCategoriaNormativaN1::getRepository()->findOneById($normativa->getSubcategoriaNormativaUnoId())->getNombre()?></span> <br />   
	  <?php //endif;?>
	  <?php // if($normativa->getSubcategoriaNormativaDosId()):?>
	  <span class="notfecha">Sub-categor&iacute;a (nivel 2): <?php //echo SubCategoriaNormativaN2::getRepository()->findOneById($normativa->getSubcategoriaNormativaDosId())->getNombre()?></span> <br />   
	  <?php //endif;?>-->
	  <?php echo nl2br($normativa->getcontenido()) ?>      
	  <div class="clear"></div>
	  <br clear="all">
	   <?php if($normativa->getDocumento()):?>   
	  <a href="<?php echo url_for("/uploads/normativas/docs/".$normativa->getDocumento())?>" target="_blank" class="notentrada">Documento +</a> 
	  <?php endif;?>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('normativas/editar?id='.$normativa->getId()) ?>';"/>
	<?php endif;?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('normativas/index') ?>';"/>
	</div>
