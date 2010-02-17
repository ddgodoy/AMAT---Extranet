<?php
	use_helper('Javascript');
	use_helper('Security');
	
	include_stylesheets_for_form($form);
	include_javascripts_for_form($form);
?>
<?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>
	
<?php
	echo $form['fecha']->renderError();
	echo $form['titulo']->renderError();
	echo $form['organizador']->renderError();
	echo $form['descripcion']->renderError();
	echo $form['mas_info']->renderError();
?>
<form action="<?php echo url_for('eventos/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" '?> id="evento" name="evento">
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
	
	    <table width="100%" cellspacing="0" cellpadding="0" border="0">
	      <tbody><tr>
	        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
	        <td width="52%" align="right"> </td>
	      </tr>
	    </tbody>
	    </table>
	    <fieldset>
        <legend>Evento</legend>
          <table width="100%" border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td width="7%"><label>Fecha*</label></td>
          <td width="93%" valign="middle">
            <?php echo $form['fecha'] ?>
							<!-- <label style="margin-left: 4px;">Fecha de Caducidad</label> -->
            <?php // echo $form['fecha_caducidad']; ?>
          </td>
          </tr>
          <tr>
           <td><label style="margin-left:4px;">T&iacute;tulo*</label></td>
            <td><?php echo $form['titulo'] ?></td>
           </tr>
           <tr>
           <td style="padding-top: 5px;"><label>Ambito</label></td>
           <td style="padding-top: 5px;"><?php echo $form['ambito'] ?></td>
           <tr>
             <td valign="top"><label>Descripci&oacute;n</label></td>
             <td><?php echo $form['descripcion'] ?></td>
           </tr>
           <tr>
             <td valign="top" style="padding-top: 5px;"><label>Detalle</label></td>
             <td style="padding-top: 5px;"><?php echo $form['mas_info'] ?></td>
           </tr>
           </tr>
               <tr>
               <td><label style="margin-left:4px;">Organizador</label></td>
               <td><?php echo $form['organizador'] ?></td>
           </tr>
           <tr>
	          <td style="padding-top: 5px;"><label>Imagen</label></td>
	          <td style="padding-top: 5px;"><label><?php echo $form['imagen'] ?></label></td>
	        </tr>
	        <tr>
	          <td style="padding-top: 5px;"><label>Archivo</label></td>
	          <td style="padding-top: 5px;"><label>
	            <?php echo $form['documento'] ?>
	          </label></td>
        </tr>
         </table>
         <div class="clear"></div>
				<div class="clear"></div>
				<!-- * -->
				<?php if (!$form->getObject()->isNew()): ?>
				<fieldset style="float:left; margin-right:10px;width:445px; margin-left:90px; ">
					<legend>Destinatarios del evento</legend>
					<span style="float:left"><?php echo $form['usuarios_list'] ?></span>
				</fieldset>
				<?php endif; ?>
				<!-- * -->
         <?php echo $form->renderHiddenFields() ?>
        </fieldset>
		    <div class="botonera">
		    <?php if(validate_action('alta')):?> 
		      <input value="Guardar" class="boton" id="boton_guardado" type="submit" />
		      <input value="Guardar Pendiente" class="boton" id="boton_pendiente" type="submit" />
		     <?php endif ?>

		     <?php if(validate_action('publicar')): ?>
		      	<input value="Publicar" class="boton" id="boton_publicar" type="submit" />
		     <?php endif;?>
		     <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('eventos/index') ?>';"/>
		    </div>
	</form>

<?php if(validate_action('alta')):?>
	<script language="javascript" type="text/javascript">
		$('boton_guardado').observe('click',  setGuardar);  function setGuardar(event)  { $('evento_estado').value = 'guardado'; }
		$('boton_pendiente').observe('click', setPendiente); function setPendiente(event) { $('evento_estado').value = 'pendiente'; }
	</script>
<?php endif ?>

<?php if(validate_action('publicar')): ?>
	<script language="javascript" type="text/javascript">
		$('boton_publicar').observe('click',  setPublicar); function setPublicar(event) { $('evento_estado').value = 'publicado'; }
	</script>
<?php endif ?>