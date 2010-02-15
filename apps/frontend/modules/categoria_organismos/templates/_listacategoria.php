<?php 
// plantilla del componente categoria_organismo
echo select_tag('categoria_organismo_id',
options_for_select(array('0'=>'-- seleccionar --') + _get_options_from_objects($arrayCategoria), $categoria_organismos_selected),
array('style'=>'width:200px;','class'=>'form_input')
);
echo observe_field('categoria_organismo_id', array('update'=>'content_subcategoria','url'=>'documentacion_organismos/listByCategoriaOrganismo','with'=>"'id_categoria_organismo='+value",'script'   => true));
?>