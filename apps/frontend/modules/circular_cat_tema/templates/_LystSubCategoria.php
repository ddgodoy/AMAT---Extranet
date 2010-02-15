<?php use_helper('TestPager', 'Object') ?>
<?php use_helper('Security', 'Javascript') ?>
<?php if($subCAtTem):?>
	   <ul>
	   <?php foreach ($subCAtTem AS $sub):?>
	     <?php if($modulo == 'circulares'):?>
	      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_tema='.$id.'&select_sub_tema='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
	     <?php endif;?> 
	     <?php if($modulo == 'iniciativas'):?>
	      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_ini='.$id.'&iniciativa[subcategoria_iniciativa_id]='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
	     <?php endif;?> 
	     <?php if($modulo == 'normativas'):?>
	      <li><?php echo link_to_remote($sub->getNombre(),array('update'=>'tem2'.$sub->getId(),'url'=>'circular_cat_tema/listSubCategoria2?tabla='.$tabla.'&modulo='.$modulo.'&categoria='.$id,'with'=>"'id_sub1=".$sub->getId()."'",'script'   => true,));?></a> </li>
         <div id="<?php echo 'tem2'.$sub->getId()?>"></div> 
	     <?php endif;?> 
	   <?php endforeach;?>   
	  </ul> 
<?php endif;?>