<?php
    $arrayGrupoConsejo=array();
    $arrayGrupoConsejo=array('0'=>'-- seleccionar --') + $arrayGrupodeTrabajo ;
    
	echo select_tag('grupodetrabajo',
	options_for_select($arrayGrupoConsejo, $grupo_selected),
	array('style'=>'width:200px;','class'=>'form_input'));
?>