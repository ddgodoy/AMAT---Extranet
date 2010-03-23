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
	echo $form->renderGlobalErrors();
	echo $form['titulo']->renderError();
	echo $form['entradilla']->renderError();
	echo $form['autor']->renderError();
	echo $form['fecha']->renderError();
	echo $form['fecha_publicacion']->renderError();
	echo $form['fecha_caducidad']->renderError();
	echo $form['imagen']->renderError();
	echo $form['documento']->renderError();
?>
<form action="<?php echo url_for('noticias/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
      </tr>
    </tbody></table>
    <div class="botonera">
    </div>
    <fieldset>
      <legend>Noticia</legend>
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
        <tbody><tr>
          <td width="7%"><label>Fecha*: </label></td>
          <td width="93%" valign="middle">
            <?php echo $form['fecha'] ?>
            <?php if(validate_action('publicar')):?>
            <label style="margin-left: 4px;">Fecha de Publicación*: </label><?php echo $form['fecha_publicacion'] ?>
            <label style="margin-left: 4px;">Fecha de Caducidad:  </label><?php echo $form['fecha_caducidad'] ?>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td><label>Autor / Medio:</label></td>
          <td valign="middle">
          	<?php echo $form['autor'] ?>
          </td>
        </tr>
        <tr>
          <td><label>Título*</label></td>
          <td valign="middle">
          	<?php echo $form['titulo'] ?> <label>Destacada</label> <?php echo $form['destacada'] ?>&nbsp;&nbsp;<label>Novedad</label> <?php echo $form['novedad'] ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><label>Ambito</label></td>
          <td><?php echo $form['ambito'] ?></td>
        </tr>
        <tr>
          <td valign="top"><label>Entradilla</label></td>
          <td><?php echo $form['entradilla'] ?></td>
        </tr>
        <tr>
          <td valign="top" style="padding-top: 5px;"><label>Más Información</label></td>
          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
        </tr>
        <tr>
          <td style="padding-top: 5px;"><label>Imagen</label></td>
          <td style="padding-top: 5px;" width="93%"><label><?php echo $form['imagen'] ?></label><label><?php echo $form['mas_imagen'] ?></label><label>Mostrar la imagen en la ficha</label>
          </td>
        </tr>
        <tr>
          <td style="padding-top: 5px;"><label>Archivo</label></td>
          <td style="padding-top: 5px;"><label>
            <?php echo $form['documento'] ?>
          </label></td>
        </tr>
        <tr>
          <td style="padding-top: 5px;" height="10%"></td>
        </tr>
      </tbody>
      </table>
      <?php echo $form->renderHiddenFields() ?>
    </fieldset>
    <div class="botonera">
    <?php if(validate_action('alta')):?> 
      <input type="submit" id="boton_guardar_g" class="boton" value="Guardar" name="btn_action"/>
    <?php
     endif; if(validate_action('alta')):?> 
      <input type="submit" id="boton_guardar" class="boton" value="Guardar Pendiente" name="btn_action"/>
    <?php
     endif;
     if(validate_action('publicar')):
    ?>
      <input type="submit" id="boton_publicar" class="boton" value="Guardar Publicado" name="btn_volver2"/>
    <?php 
    endif;
    ?>
      <input type="button" id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('noticias/index') ?>';"/>
    </div>
</form>   
<?php if(validate_action('alta')):?>
<script language="javascript" type="text/javascript">
	$('boton_guardar_g').observe('click', setGuardar);  function setGuardar(event) {$('noticia_estado').value = 'guardado';}	
</script>
<?php 
endif;
if(validate_action('alta')):?>
<script language="javascript" type="text/javascript">
	$('boton_guardar').observe('click', setPendiente);  function setPendiente(event) {$('noticia_estado').value = 'pendiente';}	
</script>
<?php 
endif;
if(validate_action('publicar')):
?>
<script>	
	$('boton_publicar').observe('click', setPublicado); function setPublicado(event) {$('noticia_estado').value = 'publicado';}
</script>
<?php 
endif;
?>