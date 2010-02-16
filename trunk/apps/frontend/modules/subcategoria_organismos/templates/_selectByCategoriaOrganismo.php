<?php
	use_helper('Object');
	echo select_tag($name.'[subcategoria_organismo_id]',
	options_for_select( array('0'=>'-- seleccionar --') + _get_options_from_objects($arraySubcategoria), $subcategoria_organismos_selected),
	array('style'=>'width:250px;','class'=>'form_input'));
?>