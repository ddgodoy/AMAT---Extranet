 <?php if($subCAtOrg): ?>
 
	   <ul>
	   <?php foreach ($subCAtOrg AS $sub):?>
	      <li> <a href="<?php echo url_for("circulares/index?subcategoria_organismo_id=".$sub->getId()."&categoria_organismo_id=$idCart")?>"><?php echo $sub->getNombre();?> </a> </li>
	   <?php endforeach;?>   
	  </ul>
<?php endif;?>   