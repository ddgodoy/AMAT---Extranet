<?php use_helper('Security');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('acuerdo/index') ?>">Acuerdos</a> &gt; <?php echo  $acuerdo->getnombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Acuerdo</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<div class="lineaListados">  
	</div>	
	
	<div class="noticias">	  
	  <span class="notfecha">Publicado el: <?php echo date("d/m/Y", strtotime($acuerdo->getFecha())) ?></span> <br />
	  <a href="#" class="nottit"><?php echo  $acuerdo->getnombre() ?></a><br />
	  <?php if($acuerdo->getCategoriaAcuerdoId()):?>
          <span class="notfecha">Categor&iacute;a: <?php echo CategoriaAcuerdo::getRepository()->findOneById($acuerdo->getCategoriaAcuerdoId())->getNombre()?></span> <br />
	  <?php endif;?>
	  <?php if($acuerdo->getSubcategoriaAcuerdoId()):?>
          <span class="notfecha">Sub-categor&iacute;a: <?php echo SubCategoriaAcuerdo::getRepository()->findOneById($acuerdo->getSubcategoriaAcuerdoId())->getNombre()?></span> <br />
	  <?php endif;?>
	  <?php echo nl2br($acuerdo->getcontenido()) ?>
	 <br clear="all" />
	  <?php if ($acuerdo->getDocumento()): ?>
	   <a href="<?php echo url_for("/uploads/acuerdo/docs/".$acuerdo->getDocumento())?>" class="descargar-documento" target="_blank">Documento +</a>
	  <?php endif; ?>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('acuerdo/editar?id='.$acuerdo->getId()) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('acuerdo/index') ?>';"/>
	</div>
