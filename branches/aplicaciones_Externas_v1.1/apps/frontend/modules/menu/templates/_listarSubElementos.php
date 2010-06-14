<?php
  // plantilla del componete 
	use_helper('Object');
  use_helper('Javascript');
	echo select_tag('subElementos_id',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arraySubElementos), $Elementos_sub_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
?>