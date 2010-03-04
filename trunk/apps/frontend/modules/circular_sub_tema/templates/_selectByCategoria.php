<?php
	use_helper('Object');
	
	if($name!= '')
	{
		$nombre = $name.'[circular_sub_tema_id]';
	}
	else 
	{
		$nombre = 'select_sub_tema';
	}
	echo select_tag($nombre,
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arraySubcategoriasTema), $sub_tema_selected),
	array('style'=>'width:250px;','class'=>'form_input'));
?>