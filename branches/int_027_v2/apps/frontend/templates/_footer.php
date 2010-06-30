<div class="push"></div>
</div>
<form name="myAplicationFrom" id="myAplicationFrom" action="" method="post" target="_blank">
<?php echo input_hidden_tag('userHidden', ''); ?>
<?php echo input_hidden_tag('passHidden', ''); ?>
</form>
<div class="foot">
  <p class="copy">&copy; Copyright AMAT  2010</p>
  <div class="right">
  	Contacto / Sugerencias&nbsp;
    <a href="<?php echo url_for('contacto/index') ?>" class="sobre">
    	<?php echo image_tag('mensaje.png', array('alt' => 'Mensaje', 'width' => 24, 'height' => 15, 'border' => 0)) ?>
    </a>
  </div>
</div>