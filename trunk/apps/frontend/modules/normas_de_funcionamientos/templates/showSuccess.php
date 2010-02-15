<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('normas_de_funcionamientos/index') ?>">Normas de funcionamiento</a> &gt; <?php echo  $Normas->getTitulo() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="95%"><h1>Normas de funcionamiento</h1></td>
	    <td width="5%" align="right">&nbsp;</td>
	  </tr>
	</table>
    
	<?php  include_partial('miembros_grupo/MenuGrupo',array('Grupo' => $Grupo, 'modulo'=>$modulo))?>
	
	
	<div class="noticias">
	  <a href="#" class="nottit"><?php echo  $Normas->getTitulo() ?></a><br />
	  <p class="notentrada"></p>
	  
	  <?php echo $Normas->getDescripcion() ?>  
	  
	  <br><br><span class="notfecha">Fecha de creaci&oacute;n: <?php echo date("d/m/Y", strtotime($Normas->getCreatedAt())) ?></span><br />     
	   <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera">
	<?php if(validate_action('modificar')):?>
	  <input type="button" id="boton_cancel" class="boton" value="Editar" name="boton_cancel" onclick="document.location='<?php echo url_for('normas_de_funcionamientos/editar?id='.$Normas->getId()) ?>';"/>
	<?php endif; ?>  
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('normas_de_funcionamientos/index') ?>';"/>
	</div>