<h2 class="grupo"><?php if($organismo!=''): echo $organismo->getCategoriaOrganismo()->getNombre().' '.$organismo->getSubCategoriaOrganismo()->getNombre() .' '.$organismo->getNombre(); $get = '?organismo='.$organismo->getId(); else: $get= ''; echo 'Organismos'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <!--<a <?php //if($modulo != 'normas_de_funcionamientos'):?> href="<?php //echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php // else: ?> class="seleccionado" <?php //endif; ?>>Normas de Funcionamiento</a> | -->
       <?php if ( validate_action('listar','miembros_organismo')): ?><a <?php if($modulo != 'miembros_organismo'):?> href="<?php echo url_for('miembros_organismo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros de Organismos</a> | <?php endif;?>
       <?php if ( validate_action('listar','asambleas')): ?><a <?php if($modulo != 'asambleas'):?> href="<?php echo url_for('asamblea_organismo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | <?php endif;?>
       <?php if ( validate_action('listar','acta')): ?><a <?php if($modulo != 'acta'):?> href="<?php echo url_for('acta_organismos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | <?php endif;?>
       <?php if($organismo!=''){$getDoc = '?documentacion_organismo[organismo_id]='.$organismo->getId();}else{$getDoc = '';}?>
       <?php if ( validate_action('listar','documentacion_organismos')): ?><a <?php if($modulo != 'documentacion_organismos'):?> href="<?php echo url_for('documentacion_organismos/index'.$getDoc); ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a><?php endif;?>
</div>