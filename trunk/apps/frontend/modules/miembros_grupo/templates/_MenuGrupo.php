<h2 class="grupo"><?php if ($Grupo): echo $Grupo->getNombre(); $get = '?grupo='.$Grupo->getId(); else: $get= ''; echo 'Grupos de Trabajo'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <?php if ( validate_action('listar','normas_de_funcionamientos')): ?><a <?php if($modulo != 'normas_de_funcionamientos'):?> href="<?php echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Normas de Funcionamiento</a> | <?php endif;?>
       <?php if ( validate_action('listar','miembros_grupo')): ?><a <?php if($modulo != 'miembros_grupo'):?> href="<?php echo url_for('miembros_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros del Grupo de Trabajo</a> | <?php endif;?>
       <?php if ( validate_action('listar','asambleas')): ?><a <?php if($modulo != 'asambleas'):?> href="<?php echo url_for('asamblea_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | <?php endif;?>
       <?php if ( validate_action('listar','acta')): ?><a <?php if($modulo != 'acta'):?> href="<?php echo url_for('acta_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | <?php endif;?>
       <?php if ( validate_action('listar','documentacion_grupos')): ?><a <?php if($modulo != 'documentacion_grupos'):?> href="<?php echo url_for('documentacion_grupos/index'.$get) ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a><?php endif;?>
</div>