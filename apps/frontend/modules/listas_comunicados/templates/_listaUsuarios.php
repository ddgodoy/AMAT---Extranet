<?php use_helper('Javascript', 'Object') ?>
<?php foreach ($arrUsuarios AS $K =>$r):?>
<option value="<?php echo $K ?>"><?php echo $r ?></option>
<?php endforeach;?>