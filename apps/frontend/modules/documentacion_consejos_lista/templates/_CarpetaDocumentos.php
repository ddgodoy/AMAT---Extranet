<?php
 if (validate_action('listar','archivos_c_t') && $valor->getEstado() == 'publicado' ) {
 echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoCT::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_c_t_lista/index?archivo_c_t[documentacion_consejo_id]=' . $valor->getId().'&consejo_territorial_id='.$valor->getConsejoTerritorialId(), array('method' => 'post'));
 }
 elseif($sf_user->getAttribute('userId')== $valor->getUserIdCreador()){
 echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoCT::getRepository()->getAllByDocumentacion($valor->getId())->count().' Archivo/s')), 'archivos_c_t_lista/index?archivo_c_t[documentacion_consejo_id]=' . $valor->getId().'&consejo_territorial_id='.$valor->getConsejoTerritorialId(), array('method' => 'post'));
 }
?>
