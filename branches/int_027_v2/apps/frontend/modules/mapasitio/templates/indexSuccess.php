<?php use_helper('Security');
$r = 0;
?>
<div class="content">
    <div class="mapaweb">
      <h1>Mapa de Web</h1>
      <div>
                    <?php
                            foreach ($sf_user->getAttribute('menu') as $item) { $r++;

                                    $banderaInicio = 0;

                                    if (count($item['hijos']) >= 1) {
                                            foreach ($item['hijos'] as $verelmoduloInicial) {
                                                    if (validate_action('listar', $verelmoduloInicial['modulo']) || validate_action('publicar', $verelmoduloInicial['modulo'])) {
                                                            $banderaInicio = 1;
                                                    }
                                            }
                                            if ($banderaInicio == 1) {
                                            if($r==1){echo  '<div class="col1">';}echo '<ul class="tema">';
                                                    $arrayMenuPadre = getArrayMenuElementsByConditions($item['hijos']);

                                                    if (!empty($arrayMenuPadre)) {
                                                            echo '<h4><li id="primerNivel" class="current">'.$item['nombre'].'<ul></h4>';

                                                            foreach ($arrayMenuPadre as $hijo) {
                                                                    $cssLinkHijo = $hijo['hijos'] ? ' class="current" ' : ' ';
                                                                    $hrfLinkHijo = $hijo['aplicacion'] ? 'aplicacion' : 'url';

                                                                    echo '<li><a'.$cssLinkHijo.'href="'.url_for($hijo[$hrfLinkHijo]).'">'.$hijo['nombre'].'</a>';

                                                                    if (count($hijo['hijos']) >= 1) {
                                                                            $banderahijo = 0;

                                                                            foreach ($hijo['hijos'] as $verelmodulo) {
                                                                                    if (validate_action('listar', $verelmodulo['modulo']) || validate_action('publicar', $verelmodulo['modulo'])) {
                                                                                            $banderahijo = 1;
                                                                                    }
                                                                            }
                                                                            if ($banderahijo == 1) {
                                                                                    echo '<ul>';

                                                                                    foreach ($hijo['hijos'] as $nieto) {
                                                                                            if (validate_action('listar', $nieto['modulo']) || validate_action('publicar', $nieto['modulo'])) {
                                                                                                    $hrfLinkNieto = $nieto['aplicacion'] ? 'aplicacion' : 'url';

                                                                                                    echo '<li><a href="'.url_for($nieto[$hrfLinkNieto]).'">'.$nieto['nombre'].'</a></li>';
                                                                                            }
                                                                                    }
                                                                                    echo '</ul>';
                                                                            }
                                                                    }
                                                                    echo '</li>';
                                                            }
                                                            echo '</ul></li>';
                                                    }
                                               echo '</ul><br clear="all"/>';
                                               if($r == 2){echo '</div>'; $r = 0; }
                                            }
                                    }
                            }
                    ?>
                    
       <br clear="all" />
      <br clear="all" />
      <br clear="all" />
      <br clear="all" />
    <ul class="especial">
        <h4>Otros Links</h4>
       <li><a href="<?php echo url_for('inicio/index') ?>" class="a">INICIO</a></li>
		<li><a href="<?php echo url_for('mapasitio/index') ?>" class="d">MAPA DE WEB</a></li>
		<li><a href="<?php echo url_for('usuarios/perfil') ?>" class="b">MIS DATOS</a></li>
        <li><a href="<?php echo url_for('contacto/index') ?>">CONTACTO</a></li>
      </ul>
       </div>
   </div>

</div>  