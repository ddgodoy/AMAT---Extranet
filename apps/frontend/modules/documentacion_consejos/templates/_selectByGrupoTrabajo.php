<?php
	use_helper('Object');

	echo select_tag('documentacion_consejo_id',
									options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayDocumentacion), $documentacion_selected),
									array('style'=>'width:330px;','class'=>'form_input'));
?>