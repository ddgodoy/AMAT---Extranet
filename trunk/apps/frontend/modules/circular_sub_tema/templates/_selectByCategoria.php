<?php
	use_helper('Object');
	echo select_tag('select_sub_tema',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arraySubcategoriasTema), $sub_tema_selected),
	array('style'=>'width:250px;','class'=>'form_input'));
?>