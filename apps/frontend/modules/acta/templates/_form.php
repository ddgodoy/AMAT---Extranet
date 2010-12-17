<?php use_helper('Javascript') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>


	<?php if ($sf_user->hasFlash('notice')): ?>
	<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form['detalle']->renderError() ?>
	
	<form action="<?php echo url_for('acta/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
	<input type="hidden" name="<?php echo $DAtos['campo'];?>" value="<?php echo $DAtos['valor'];?>" />
	    <div class="botonera">
	    </div>
	        <fieldset>
	      <legend>Acta</legend>
	      <table width="100%" border="0" cellpadding="0" cellspacing="4">
	       <tr>
	         <td width="9%"><label>Título*</label></td>
             <td valign="middle" width="91%"><?php echo $form['nombre'] ?></td>
	        </tr>
	        <tr>
	        <td valign="top" style="padding-top: 5px;"><label>Más Información</label></td>
	          <td style="padding-top: 5px;"><?php echo $form['detalle'] ?></td>
	        </tr>
	      </table>
	      
	      <?php echo $form->renderHiddenFields() ?>
	    </fieldset>
	    
	    <div class="botonera">
	      <input name="btn_action" value="Guardar" class="boton" id="boton_guardar" type="submit" />
	      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('asambleas/lista?'.$DAtos['get']) ?>';"/>
	    </div>
 </form>	