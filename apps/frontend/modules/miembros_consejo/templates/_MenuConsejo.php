<h2 class="grupo"><?php if ($Consejo): echo $Consejo->getNombre(); $get = '?consejo='.$Consejo->getId(); else: $get= ''; echo 'Consejo Territorial'; endif; ?> </h2>
       <div class="navegacion-grupos">
       <!--<a <?php // if($modulo != 'normas_de_funcionamientos'):?> href="<?php //echo url_for('normas_de_funcionamientos/index'.$get) ?>" <?php // else: ?> class="seleccionado" <?php //endif; ?>>Normas de Funcionamiento</a> | -->
       <a <?php if($modulo != 'miembros_consejo'):?> href="<?php echo url_for('miembros_consejo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Miembros del Consejo Territorial</a> | 
       <a <?php if($modulo != 'asambleas'):?> href="<?php echo url_for('asamblea_consejos/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Convocatorias</a> | 
       <a <?php if($modulo != 'acta'):?> href="<?php echo url_for('acta_consejo/index'.$get) ?>" <?php else: ?> class="seleccionado" <?php endif; ?>>Actas </a> | 
       <a <?php if($modulo != 'documentacion_consejos'):?> href="<?php echo url_for('documentacion_consejos/index'.$get) ?>" <?php else:?> class="seleccionado" <?php endif; ?>>Documentaci&oacute;n</a>
</div>