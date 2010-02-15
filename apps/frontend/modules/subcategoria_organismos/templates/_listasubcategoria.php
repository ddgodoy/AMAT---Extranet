<?php
  // plantilla del componete subcategoria_organismo
	use_helper('Object');
  use_helper('Javascript');
	echo select_tag('subcategoria_organismo_id',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arraySubcategoria), $subcategoria_organismos_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
	echo observe_field('subcategoria_organismo_id', array('update'=>'content_organismos','url'=>'organismos/listByOrganismoAct','with'=>"'subcategoria_organismos='+value",'script'   => true));								
?>