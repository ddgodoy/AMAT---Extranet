<?php include_partial('header') ?>
<?php include_partial('global/help') ?>

<div class="head">
  <div class="img1">
  	<?php echo image_tag('logo.png', array('width' => 249, 'height' => 66, 'alt' => 'Amat')) ?>
  	<h1>Extranet Sectorial AMAT</h1>
  </div>	
</div>

<?php include_partial('seguridad/form', array('form' => $form)) ?>

</body>
</html>