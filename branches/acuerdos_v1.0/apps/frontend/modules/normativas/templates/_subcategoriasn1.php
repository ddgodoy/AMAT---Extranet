<?php use_helper('Javascript', 'Object') ?>
<?php echo $witSub['subcategoria_normativa_uno_id'];
echo  observe_field('normativa_subcategoria_normativa_uno_id',array('update'=>'dos','url'=>'normativas/subcategoriasn2','with'=>"'id_subcategoria='+value",'script'   => true,))?>
