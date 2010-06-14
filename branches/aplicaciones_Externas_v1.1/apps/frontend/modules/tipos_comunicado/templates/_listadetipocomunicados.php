<?php
  use_helper('Object');
  use_helper('Javascript');
  
	echo select_tag('tiposdecomunicadosId',
	options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayTiposdeComunicados), $Tipos_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
?>