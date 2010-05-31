<script language="JavaScript">

function SetAllCheckBoxes(formName, className, checkValue)
{
	var checkboxs = $$("input." + className);
	checkboxs.each(function(s) {
		s.checked = checkValue;
	});
}

</script>

    <div class="mapa">
      <strong>Directores Gerente</strong> > <a href="<?php echo url_for('asambleas/index') ?>">Convocatoria - Asamblea</a> > Convocar
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="95%"><h1>Asamblea</h1></td>
        <td width="5%" align="right"><a href="#"><?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?></a></td>
      </tr>
    </tbody></table><br/>
    
    <?php if(count($usuariosConvocadosActualesArray) > 0): ?>
    	<p>La convocatoria ha sido cerrada. Para ver los convocados entre a <a href="<?php echo url_for('asambleas/convocados?id=' . $asambleaId) ?>">Convocados</a></p>
    <?php elseif ($asamblea->getEstado() == 'anulada'): ?>
    	<p>La asamblea ha sido anulada. Para ver todas las asambleas entre a <a href="<?php echo url_for('asambleas/index') ?>">Asambleas</a></p>
    <?php else: ?>
    
	    <?php if ($sf_user->hasFlash('notice')): ?>
	     <ul class="ok_list"><li><?php echo $sf_user->getFlash('notice') ?></li></ul>
	    <?php endif; ?>
	    
	    <form action="" name="convocados" method="post">
	    <input type="hidden" name="asamblea_id" value="<?php echo $asambleaId ?>" />
	    
	    <?php if (count($directores) > 0): ?>
	    <fieldset>
	      <legend>Directores:</legend>
	      <table>
	        <tr>
	          <td><input type="button" value="Seleccionar todos" onclick="SetAllCheckBoxes('convocados', 'director',  true);"/></td>
	          <td><input type="button" value="Quitar todos" onclick="SetAllCheckBoxes('convocados', 'director', false);"/></td>
	        </tr>
	      <?php foreach ($directores as $usuario): ?>
	        <tr>
	          <td><input type="checkbox" class="director" name="convocados[director][<?php echo $usuario->getid() ?>]" <?php echo (array_search($usuario->getid(), $usuariosConvocadosActualesArray))?'checked=checked':'' ?> />
	          <?php echo $usuario->getApellido() . ', ' . $usuario->getNombre() ?></td>
	        </tr>
	      <?php endforeach; ?>
	      </table>
	    </fieldset>
	    <?php endif; ?>
	    
	    <?php foreach ($gruposTrabajo as $grupoTrabajo): ?>
	    <?php $usuarios = Doctrine::getTable('Usuario')->getUsuariosByGrupoTrabajo($grupoTrabajo->getId(), $sf_user->getAttribute('userId')) ?>
	    <?php if (count($usuarios) > 0): ?>
	    <fieldset>
	      <legend>Grupo de Trabajo: <?php echo $grupoTrabajo->getNombre() ?></legend>
	      <table>
	        <tr>
	          <td><input type="button" value="Seleccionar todos" onclick="SetAllCheckBoxes('convocados', 'gt_<?php echo $grupoTrabajo->getId() ?>',  true);"/></td>
	          <td><input type="button" value="Quitar todos" onclick="SetAllCheckBoxes('convocados', 'gt_<?php echo $grupoTrabajo->getId() ?>', false);"/></td>
	        </tr>
	      <?php foreach ($usuarios as $usuario): ?>
	        <tr>
	          <td><input type="checkbox" class="gt_<?php echo $grupoTrabajo->getId() ?>" name="convocados[gt_<?php echo $grupoTrabajo->getId() ?>][<?php echo $usuario->getid() ?>]" <?php echo (array_search($usuario->getid(), $usuariosConvocadosActualesArray))?'checked=checked':'' ?> />
	          <?php echo $usuario->getApellido() . ', ' . $usuario->getNombre() ?></td>
	        </tr>
	      <?php endforeach; ?>
	      </table>
	    </fieldset>
	    <?php endif; ?>
	    <?php endforeach; ?>
	    
	    <?php foreach ($consejosTerritoriales as $consejoTerritorial): ?>
	    <?php $usuarios = Doctrine::getTable('Usuario')->getUsuariosByConsejoTerritorial($consejoTerritorial->getId(), $sf_user->getAttribute('userId')) ?>
	    <?php if (count($usuarios) > 0): ?>
	    <fieldset>
	      <legend>Consejo Territorial: <?php echo $consejoTerritorial->getNombre() ?></legend>
	      <table>
	        <tr>
	          <td><input type="button" value="Seleccionar todos" onclick="SetAllCheckBoxes('convocados', 'ct_<?php echo $consejoTerritorial->getId() ?>',  true);"/></td>
	          <td><input type="button" value="Quitar todos" onclick="SetAllCheckBoxes('convocados', 'ct_<?php echo $consejoTerritorial->getId() ?>', false);"/></td>
	        </tr>
	      <?php foreach ($usuarios as $usuario): ?>
	        <tr>
	          <td><input type="checkbox" class="ct_<?php echo $consejoTerritorial->getId() ?>" name="convocados[ct_<?php echo $consejoTerritorial->getId() ?>][<?php echo $usuario->getid() ?>]" <?php echo (array_search($usuario->getid(), $usuariosConvocadosActualesArray))?'checked=checked':'' ?> />
	          <?php echo $usuario->getApellido() . ', ' . $usuario->getNombre() ?></td>
	        </tr>
	      <?php endforeach; ?>
	      </table>
	    </fieldset>
	    <?php endif; ?>
	    <?php endforeach; ?>
	    
	    <div>
	      <input type="submit" value="Confirmar Convocados" />
	    </div>
    
    	</form>
    	
    <?php endif; ?>