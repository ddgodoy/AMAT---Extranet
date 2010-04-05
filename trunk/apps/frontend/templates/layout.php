<?php //echo $sf_user->getAttribute('userId'); exit ();
if(!$sf_user->getAttribute('userId')): ?>
	<?php $sf_context->getController()->redirect('seguridad/index') ?>
<?php endif; ?>

<?php //echo 'module =>'.$sf_context->getModuleName().'<br> action =>'.$sf_context->getActionName(); exit();?>
<?php include_component('seguridad', 'verificar', array('module' => $sf_context->getModuleName(), 'action' => $sf_context->getActionName())) ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Amat Admin</title>
	</head>
	<body>
		<div class="wrapper">
			<?php if($sf_user->getAttribute('userId')): ?>
		  <?php
		  	include_partial('global/help');
		  	include_partial('global/top');
		  	include_partial('global/header');
		  ?>
			<?php endif; ?>
		  <div class="content"><?php echo $sf_content ?></div>

			<script type="text/javascript">
			<!--
			var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
			//-->
			</script>		
			<?php include_partial('global/footer') ?>
	</body>
</html>