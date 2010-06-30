<?php use_helper('Javascript') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($form['estado']->getValue() == 'anulada'): ?>
	<p>Esta asamblea ha sido anulada. Para ver todas las asambleas entre a <a href="<?php echo url_for('asambleas/index') ?>">Asambleas</a></p>
<?php elseif ($form['estado']->getValue() == 'caducada'): ?>
	<p>Esta asamblea ha caducado. Para ver todas las asambleas entre a <a href="<?php echo url_for('asambleas/index') ?>">Asambleas</a></p>
<?php elseif ($form['estado']->getValue() == 'activa' && !$form->getObject()->isNew()): ?>
	<p>Esta asamblea no puede ser modificada. Para ver todas las asambleas entre a <a href="<?php echo url_for('asambleas/index') ?>">Asambleas</a></p>
<?php else: ?>

	<?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	<?php endif; ?>
	
	<?php echo $form['fecha']->renderError() ?>
	<?php echo $form['fecha_caducidad']->renderError() ?>
	<?php echo $form['titulo']->renderError() ?>
	<?php echo $form['horario']->renderError() ?>
	<?php echo $form['direccion']->renderError() ?>
	<?php echo $form['fecha_caducidad']->renderError() ?>
	<?php if($DAtos['valor']==1):?>
	<?php echo $form['usu']->renderError() ?>
	<?php endif;?>
	<?php echo $form['contenido']->renderError() ?>
	
	<form action="<?php echo url_for('asambleas/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
	<?php endif; ?>
	<input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
	    <table width="100%" cellspacing="0" cellpadding="0" border="0">
	      <tbody><tr>
	        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
	        <td width="52%" align="right"> </td>
	      </tr>
	    </tbody></table>
	    <div class="botonera">
	    </div>
	        <fieldset>
	      <legend>Asamblea</legend>
	      <table width="100%" border="0" cellpadding="0" cellspacing="4">
	        <tr>
	          <td width="7%"><label>Fecha*</label></td>
	          <td width="93%" valign="middle">
	            <?php echo $form['fecha'] ?>
	          <label style="margin-left:4px;">Fecha de Caducidad*</label>
	            <?php echo $form['fecha_caducidad'] ?>
	          </td>
	        </tr>
	        <tr>
	          <td><label><?php echo __('T&iacute;tulo') ?>*</label></td>
	          <td valign="middle"><?php echo $form['titulo'] ?>
	          <label style="margin-left:4px;">Horario*: </label><?php echo $form['horario'] ?>
	          </td>
	        </tr>
	        <tr>
	          <td valign="top"><label>Direcci&oacute;n*</label></td>
	          <td><?php echo $form['direccion'] ?>
	          <?php if($DAtos['busqueda']):?>
	          <label style="margin-left:4px;"><?php echo $DAtos['busqueda'].'*'?></label><?php echo $form['entidad'] ?>
	          <?php endif;?>
	          </td>
	        </tr>
	        <tr>
	          <td valign="top" style="padding-top: 5px;"><label>M&aacute;s Informaci&oacute;n</label></td>
	          <td style="padding-top: 5px;"><?php echo $form['contenido'] ?></td>
	        </tr>
	        <?php if($DAtos['valor']==1):?>
	        <tr>
	          <td valign="top" style="padding-top: 5px;"><label>Dirrectores Gerentes</label></td>
	          <td style="padding-top: 5px;"><?php echo $form['usu'] ?></td>
	        </tr>
	        <?php endif;?>
	      </table>
	      
	      <?php echo $form->renderHiddenFields() ?>
	      <input type="hidden" name="convocar" id="convocar" value="0" />
	      
	      
	    </fieldset>
	    
	    <div class="botonera">
	      <input name="btn_action" value="Guardar" class="boton" id="boton_guardar" type="submit" />
	      <input name="btn_volver" value="Anular" class="boton" id="boton_anular" type="submit" />
	      <input name="btn_volver2" value="Convocar" class="boton" id="boton_convocar" type="submit" />
		  <input type="button"  id="boton_cancel" class="boton" value="Volver" name="boton_cancel" onclick="document.location='<?php echo url_for('asambleas/index?'.$DAtos['get']) ?>';"/>

	    </div>
	</form>
	<script>
	
	$('boton_guardar').observe('click', setGuardar);
	function setGuardar(event) {
		$('asamblea_estado').value = 'pendiente';
		$('convocar').value = 0;
	}
	
	$('boton_anular').observe('click', setAnular);
	function setAnular(event) {
		$('asamblea_estado').value = 'anulada';
		$('convocar').value = 0;
	}
	
	$('boton_convocar').observe('click', setConvocar);
	function setConvocar(event) {
		$('asamblea_estado').value = 'pendiente';
		$('convocar').value = 1;
	}
	
	</script>
	
<?php endif; ?>