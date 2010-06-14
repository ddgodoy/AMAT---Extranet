<?php use_helper('TestPager', 'Object') ?>
<?php use_helper('Security', 'Javascript') ?>
<?php if($subCAtTem):?>
	   <ul>
	   <?php foreach ($subCAtTem AS $sub):?>
	      <li> <a href="<?php echo url_for($modulo.'/index?select_cat_nor='.$categoria.'&normativa[subcategoria_normativa_uno_id]='.$id.'&normativa[subcategoria_normativa_dos_id]='.$sub->getId())?>"><?php echo $sub->getNombre();?> </a> </li>
	   <?php endforeach;?>   
	  </ul> 
<?php endif;?>