<?php 
use_helper('Object');
echo select_tag('archivo_c_t[documentacion_consejo_id]',
options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayDocumentacion),$documentacion_selected),
array('style'=>'width:200px;'));
?>

