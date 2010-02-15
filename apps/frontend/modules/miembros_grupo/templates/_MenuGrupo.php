<h2 class="grupo"><?php if ($Grupo): echo $Grupo->getNombre(); $get = '?grupo='.$Grupo->getId(); else: $get= ''; echo 'Grupos de Trabajo'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <a <?php if($modulo != 'normas_de_funcionamientos'):?> href="<?php echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Normas de Funcionamiento</a> | 
       <a <?php if($modulo != 'miembros_grupo'):?> href="<?php echo url_for('miembros_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros del Grupo de Trabajo</a> | 
       <a <?php if($modulo != 'asambleas'):?> href="<?php echo url_for('asamblea_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | 
       <a <?php if($modulo != 'acta'):?> href="<?php echo url_for('acta_grupo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | 
       <a <?php if($modulo != 'documentacion_grupos'):?> href="<?php echo url_for('documentacion_grupos/index'.$get) ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a>
</div>