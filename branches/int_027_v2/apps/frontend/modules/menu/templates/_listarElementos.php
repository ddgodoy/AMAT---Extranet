<?php
  // plantilla del componete 
	use_helper('Object');
  use_helper('Javascript');
	echo select_tag('elementos_id',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayElementos), $Elementos_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
	echo observe_field('elementos_id', array('update'=>'subelemetos','url'=>'menu/subElementos','with'=>"'elementos_id='+value",'script'=> true));								
?>