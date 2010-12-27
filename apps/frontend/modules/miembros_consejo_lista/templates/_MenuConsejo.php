<h2 class="grupo">
	<?php if ($Consejo): echo $Consejo->getNombre(); $get = '?consejo='.$Consejo->getId(); else: $get= ''; echo 'Consejo Territorial'; endif; ?>
</h2>
<div class="navegacion-grupos">
	<!--<a <?php // if($modulo != 'normas_de_funcionamientos'):?> href="<?php //echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php // else: ?> class="seleccionado" <?php //endif; ?>>Normas de Funcionamiento</a> | -->

	<?php if (validate_action('listar','miembros_consejo_lista')): ?><a <?php if ($modulo != 'miembros_consejo_lista'): ?> href="<?php echo url_for('miembros_consejo_lista/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros del Consejo Territorial</a> |<?php endif;?>		
	<?php if (validate_action('listar','documentacion_consejos_lista')): ?><a <?php if ($modulo != 'documentacion_consejos_lista'): ?> href="<?php echo url_for('documentacion_consejos_lista/index'.$get) ?>" <?php else: ?> class="seleccionado"<?php endif; ?>>Documentaci&oacute;n</a><?php endif;?>
</div>