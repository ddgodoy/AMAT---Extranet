<h2 class="grupo"><?php if($organismo!=''): echo $organismo->getCategoriaOrganismo()->getNombre().' '.$organismo->getSubCategoriaOrganismo()->getNombre() .' '.$organismo->getNombre(); $get = '?organismo='.$organismo->getId(); else: $get= ''; echo 'Organismos'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <!--<a <?php //if($modulo != 'normas_de_funcionamientos'):?> href="<?php //echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php // else: ?> class="seleccionado" <?php //endif; ?>>Normas de Funcionamiento</a> | -->
       <?php if ( validate_action('listar','miembros_organismo_lista')): ?><a <?php if($modulo != 'miembros_organismo_lista'):?> href="<?php echo url_for('miembros_organismo_lista/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros de Organismos</a> | <?php endif;?>
       <?php if ( validate_action('listar','asambleas_organismos_lista')): $urlgrupas = 'asambleas_organismos_lista/index'; if($organismo){$urlgrupas.='?grupodetrabajo=Organismo_'.$organismo->getId();}?><a <?php if($modulo != 'asambleas_organismos_lista'):?> href="<?php echo url_for($urlgrupas) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | <?php endif;?>
       <?php if ( validate_action('listar','acta_organismos_lista')): $urlgrupac = 'acta_organismos_lista/index'; if($organismo){$urlgrupac.='?grupodetrabajo=Organismo_'.$organismo->getId();} ?><a <?php if($modulo != 'acta_organismos_lista'):?> href="<?php echo url_for($urlgrupac)?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | <?php endif;?>
       <?php if($organismo!=''){$getDoc = Organismo::getUrlOrganismos($organismo->getId());}else{$getDoc = '';}?>
       <?php if ( validate_action('listar','documentacion_organismos_lista')): ?><a <?php if($modulo != 'documentacion_organismos_lista'):?> href="<?php echo url_for('documentacion_organismos_lista/index?'.$getDoc); ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a><?php endif;?>
</div>