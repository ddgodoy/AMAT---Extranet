<h2 class="grupo"><?php if ($Grupo): echo $Grupo->getNombre(); $get = '?grupo='.$Grupo->getId(); else: $get= ''; echo 'Grupos de Trabajo'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <?php if ( validate_action('listar','normas_de_funcionamientos')): ?><a <?php if($modulo != 'normas_de_funcionamiento_grupos'):?> href="<?php echo url_for('normas_de_funcionamiento_grupos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Normas de Funcionamiento</a> | <?php endif;?>
       <?php if ( validate_action('listar','miembros_grupo')): ?><a <?php if($modulo != 'miembros_grupos_trabajos'):?> href="<?php echo url_for('miembros_grupos_trabajos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros del Grupo de Trabajo</a> | <?php endif;?>
       <?php if ( validate_action('listar','asambleas_grupos_trabajos')): $urlgrupas = 'asambleas_grupos_trabajos/index'; if($Grupo){$urlgrupas.='?grupodetrabajo=GrupoTrabajo_'.$Grupo->getId();} ?><a <?php if($modulo != 'asambleas_grupos_trabajos'):?> href="<?php echo url_for($urlgrupas) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | <?php endif;?>
       <?php if ( validate_action('listar','actas_grupos_trabajo')): $urlgrupac = 'actas_grupos_trabajo/index'; if($Grupo){$urlgrupac.='?grupodetrabajo=GrupoTrabajo_'.$Grupo->getId();} ?><a <?php if($modulo != 'actas_grupos_trabajo'):?> href="<?php echo url_for($urlgrupac) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | <?php endif;?>
       <?php if ( validate_action('listar','documenatcion_grupos_trabajo')): ?><a <?php if($modulo != 'documenatcion_grupos_trabajo'):?> href="<?php echo url_for('documenatcion_grupos_trabajo/index'.$get) ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a><?php endif;?>
</div>