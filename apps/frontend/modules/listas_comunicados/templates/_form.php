<?php use_helper('Javascript') ?>
<?php use_helper('Security', 'Object') ?>
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php echo $form->renderGlobalErrors() ?>

<?php if ($sf_user->hasFlash('notice')): ?>
<ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
<?php endif; ?>

<?php echo $form['nombre']->renderError() ?>
 <script language="javascript" type="text/javascript">
        var listaExcluir = '';
        var SelecPerfiListado = ''
        var SelecMutuaListado = ''
        var SelecGrupoListado = ''
        var SelecConsejoListado = ''

        function getIndicesFromSeleccionados()
        {
        	    SelecPerfiListado = $('perfieles').value;
		        SelecMutuaListado = $('mutuas').value;
		        SelecGrupoListado = $('grupos_de_trabajo').value;
		        SelecConsejoListado = $('conejo_territorial').value;
                var auxVarlistaExcluir = '';
                var listaSeleccionados = $('lista_comunicado_usuarios_list');
                
                if (listaSeleccionados.length > 0) {
                        for (var i=0; i<listaSeleccionados.length; i++) {
                                auxVarlistaExcluir += listaSeleccionados[i].value + ',';
                        }
                        auxVarlistaExcluir = auxVarlistaExcluir.substr(0,auxVarlistaExcluir.length - 1);
                }
                listaExcluir = auxVarlistaExcluir;
        }
</script>
<form action="<?php echo url_for('listas_comunicados/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
      	
      <table width="30%" cellspacing="4" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td width="7%"><label> Título *</label></td>
					<td width="20%" valign="middle" ><?php echo $form['nombre'] ?></td>
				</tr>
			</tbody>
		</table>
	<fieldset id="usuarios_lista" style="float:left; margin-right:10px;width:95%; ">
		 <legend>Filtros de lista de usuarios</legend>
		   <ul class="campos">
            <li><label> Perfil </label>
            <?php echo select_tag('perfieles',options_for_select(array(''=>'--seleccionar--')+_get_options_from_objects(Rol::getRepository()->getAllRol())), array('onchange'=>'getIndicesFromSeleccionados();')) ?></li>
            <?php echo observe_field('perfieles',array('update'=>'unassociated_lista_comunicado_usuarios_list','url'=>'listas_comunicados/lista','with'=>"'id_perfil='+SelecPerfiListado+'&id_mutuas='+SelecMutuaListado+'&id_grupos='+SelecGrupoListado+'&id_consejos='+SelecConsejoListado+'&excluir='+listaExcluir",'script'=>true))?>
            <li><label> Mutua </label>
            <?php echo select_tag('mutuas',options_for_select(array(''=>'--seleccionar--')+_get_options_from_objects(Mutua::getRepository()->getAllMutuas())), array('onchange'=>'getIndicesFromSeleccionados();')) ?></li>
            <?php echo observe_field('mutuas',array('update'=>'unassociated_lista_comunicado_usuarios_list','url'=>'listas_comunicados/lista','with'=>"'id_perfil='+SelecPerfiListado+'&id_mutuas='+SelecMutuaListado+'&id_grupos='+SelecGrupoListado+'&id_consejos='+SelecConsejoListado+'&excluir='+listaExcluir",'script'=>true))?>
            <li><label> Grupo de Trabajo </label>
            <?php echo select_tag('grupos_de_trabajo',options_for_select(array(''=>'--seleccionar--')+_get_options_from_objects(GrupoTrabajo::getRepository()->getAllGrupoTrabajo())), array('onchange'=>'getIndicesFromSeleccionados();')) ?></li>
            <?php echo observe_field('grupos_de_trabajo',array('update'=>'unassociated_lista_comunicado_usuarios_list','url'=>'listas_comunicados/lista','with'=>"'id_perfil='+SelecPerfiListado+'&id_mutuas='+SelecMutuaListado+'&id_grupos='+SelecGrupoListado+'&id_consejos='+SelecConsejoListado+'&excluir='+listaExcluir",'script'=>true))?>
            <li><label> Consejo Territorial</label>
            <?php echo select_tag('conejo_territorial',options_for_select(array(''=>'--seleccionar--')+_get_options_from_objects(ConsejoTerritorial::getRepository()->getAllconsejo())), array('onchange'=>'getIndicesFromSeleccionados();')) ?></li>
            <?php echo observe_field('conejo_territorial',array('update'=>'unassociated_lista_comunicado_usuarios_list','url'=>'listas_comunicados/lista','with'=>"'id_perfil='+SelecPerfiListado+'&id_mutuas='+SelecMutuaListado+'&id_grupos='+SelecGrupoListado+'&id_consejos='+SelecConsejoListado+'&excluir='+listaExcluir",'script'=>true))?>
           </ul>
	</fieldset>
	<fieldset id="usuarios_lista" style="float:left; margin-right:10px;width:445px; ">
      <legend>Usuarios de lista de comunicado</legend><br />
      <span style="float:left"><?php echo $form['usuarios_list'] ?>
      </span>
    </fieldset>

		
        <?php echo $form->renderHiddenFields() ?>
      </fieldset>   
	    <div class="botonera" style="padding-top:10px;">
	    <?php if(validate_action('alta') || validate_action('modificar')):?>
	      <input type="submit" id="boton_guardar" class="boton" value="Guardar" name="btn_action"/>
	    <?php endif;?>  
	      <input type="button" id="boton_cancel" class="boton" value="Cancelar" name="boton_cancel" onclick="document.location='<?php echo url_for('listas_comunicados/index') ?>';"/>
	
	    </div>   
    </form>
      
   
   
