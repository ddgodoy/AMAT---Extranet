<?php use_helper('Javascript') ?>
<?php if($arrayCategoriasTema):?>
<ul >
<?php foreach ($arrayCategoriasTema AS $cat):?>
 <li><?php echo link_to_remote($cat->getNombre(),array('update'=>'tem'.$cat->getId(),'url'=>'circular_cat_tema/listSubCategoria?tabla='.$tabla.'&modulo='.$modulo,'with'=>"'id=".$cat->getId()."'",'script'   => true,));?></a> </li>
 <div id="<?php echo 'tem'.$cat->getId()?>"></div> 
<?php endforeach;?>   
</ul>
<?php endif;?>