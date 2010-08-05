<?php
if (validate_action('listar','archivos_d_o') && $valor->getEstado() == 'publicado') {
echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDO::getCountArchivosConfidenciales($valor->getId(), $sf_user->getAttribute('userId')).' Archivo/s')), 'archivos_d_o_lista/index?archivo_d_o[documentacion_organismo_id]='.$valor->getId().'&archivo_d_o[organismo_id]='.$valor->getOrganismoId().$redireccionArchivo, array('method' => 'post'));
}
elseif($sf_user->getAttribute('userId')== $valor->getUserIdCreador()){

echo link_to(image_tag('archivos.png', array('border' => 0, 'title' => ArchivoDO::getCountArchivosConfidenciales($valor->getId(), $sf_user->getAttribute('userId')).' Archivo/s')), 'archivos_d_o_lista/index?archivo_d_o[documentacion_organismo_id]='.$valor->getId().'&archivo_d_o[organismo_id]='.$valor->getOrganismoId().$redireccionArchivo, array('method' => 'post'));
}
?>
