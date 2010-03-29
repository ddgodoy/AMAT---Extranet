<?php use_helper('Security') ?>
<?php use_helper('Date');?>
<div class="mapa">
	  <strong>Administrador </strong>&gt; <a href="<?php echo url_for('error_envio/index') ?>">Error de envio</a> &gt; <?php echo  $error_envio->getEnvioComunicado()->getComunicado()->getNombre() ?>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="50%"><h1>Error de envio</h1></td>
	    <td width="50%" align="right">&nbsp;</td>
	  </tr>
	</table>
	<br clear="all" />
	<br clear="all" />
	<div class="noticias">
	  <span class="notfecha">Fecha: <?php echo date("d/m/Y", strtotime($error_envio->getCreatedAt())) ?></span><br /><br />
	  <a class="nottit">Comunicado:</a><p class="notentrada"> <?php echo $error_envio->EnvioComunicado->Comunicado->getNombre() ?></p>
	  <a class="notentrada">Email: <a class="notentrada" href="<?php echo url_for('usuarios/editar?id='.$error_envio->getUsuarioId()) ?>"><?php echo $error_envio->Usuario->getEmail() ?></a></a><br /><br />
	  <div class="ul_noticias"><?php echo nl2br($error_envio->getError()) ?></div> 
	  <br clear="all" /> 
	  <br><br>
	   <div class="clear"></div>
	</div>
	   
	<br clear="all" />
	
	<div class="botonera"> 
	  <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('error_envio/index') ?>';"/>
	</div>