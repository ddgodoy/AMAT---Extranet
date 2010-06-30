<?php use_helper('Javascript') ?>
<?php if($arrayCategoriasOrganismos):?>
<ul >
<?php foreach ($arrayCategoriasOrganismos AS $cat):?>
 <li> 
  <li> <?php echo link_to_remote($cat->getNombre(),array('update'=>'org'.$cat->getId(),'url'=>'categoria_organismos/listSubCategoriaOrg','with'=>"'id=".$cat->getId()."'",'script'   => true,));?> </li>
 <div id="<?php echo 'org'.$cat->getId()?>"></div> 
 </li>
<?php endforeach;?>   
</ul>
<?php endif;?>