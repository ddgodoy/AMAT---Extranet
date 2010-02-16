<?php
	use_helper('Object');
    use_helper('Javascript');
	echo select_tag($name.'[organismo_id]',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayOrganismo), $organismos_selected),
	array('style'=>'width:200px;','class'=>'form_input'));									
	echo observe_field($name.'_organismo_id', array('update'=>'content_documentacion','url'=>'archivos_d_o/listDocumentacionAct','with'=>"'documentacion_organismos='+value+'&name=".$name."'",'script'   => true));																
?>