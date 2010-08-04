<?php
 if (validate_action('listar','archivos_d_g') && $valor->getEstado() == 'publicado') {
    echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getCountArchivosConfidenciales($valor->getId(), $sf_user->getAttribute('userId')).' Archivo/s')), 'archivo_d_grupo/index?archivo_d_g[documentacion_grupo_id]='.$valor->getId().'&grupo_trabajo_id='.$valor->getGrupoTrabajoId(), array('method' => 'post'));
}
elseif($sf_user->getAttribute('userId')== $valor->getUserIdCreador()){
    echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDG::getCountArchivosConfidenciales($valor->getId(), $sf_user->getAttribute('userId')).' Archivo/s')), 'archivo_d_grupo/index?archivo_d_g[documentacion_grupo_id]='.$valor->getId().'&grupo_trabajo_id='.$valor->getGrupoTrabajoId(), array('method' => 'post'));
}

?>
