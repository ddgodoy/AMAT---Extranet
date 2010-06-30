<?php use_helper('Javascript') ?>
<?php use_helper('Security') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['comunicado_id']->renderError() ?>
<?php echo $form['tipo_comunicado_id']->renderError() ?>
<?php echo $form['lista_comunicados_list']->renderError() ?>
<?php if (!empty($verComunicados) && count($verComunicados) == 0 ):?>
<div class="mensajeSistema ok">Debe ingresar un comunicado para poder enviarlo. <a href="<?php echo url_for('comunicados/nueva') ?>">click aquí</a></div>
<?php endif;?>
<form action="<?php echo url_for('envio_comunicados/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="48%"><label>Los Campos marcados con (*) son obligatorios</label></td>
        <td width="52%" align="right"> </td>
      </tr>
    </tbody></table>
    <div class="botonera" style="padding-top:10px;">
    </div>
    <fieldset>
      <legend>Lista de envio de comunicados</legend>
      	
      <table width="100%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><label> Comunicado *</label></td>
					<td width="93%" valign="middle"><?php echo $form['comunicado_id'] ?></td>
				</tr>
				<tr>
					<td width="7%"><label> Tipo de comunicado *</label></td>
					<td width="93%" valign="middle"><?php echo $form['tipo_comunicado_id'] ?></td>
				</tr>
			</tbody>
		</table>
    <br />
	<fieldset style="float:left; margin-right:10px;width:445px; ">
      <legend>Listas de envio</legend><br />
      <span style="float:left"><?php echo $form['lista_comunicados_list'] ?>
      </span>
    </fieldset>

		
      <?php echo $form->renderHiddenFields() ?>
      
    </fieldset>
    <div class="botonera" style="padding-top:10px;">
    <?php if(validate_action('alta') || validate_action('modificar')):?>
      <input type="submit" id="boton_enviar" class="boton" value="Enviar" name="btn_action"/>
    <?php endif;?>  
      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('envio_comunicados/index') ?>';"/>
    </div>
</form>