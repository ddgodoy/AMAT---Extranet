<?php
	use_helper('Object');
	echo select_tag($name.'[organismo_id]',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayOrganismo), $organismos_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
?>