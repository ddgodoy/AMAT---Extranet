<?php use_helper('Javascript') ?>
<?php if($FEcha_circulares):?>
<ul >
<?php foreach ($FEcha_circulares AS $cat):?>
 <li> <?php echo link_to_remote($cat,array('update'=>'mes'.$cat,'url'=>'circulares/listMes?modulo='.$modulo,'with'=>"'fecha=$cat'"));?> </li>
 <div id="<?php echo 'mes'.$cat?>"></div>
<?php endforeach;?>   
</ul>
<?php endif;?>