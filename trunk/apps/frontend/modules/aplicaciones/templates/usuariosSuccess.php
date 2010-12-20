<?php
	use_helper('Javascript');
	use_helper('Security');
?>
<div class="mapa">
	<strong>Administraci&oacute;n </strong>&gt; 
	<a href="<?php echo url_for('aplicaciones/index') ?>">Aplicaciones</a> &gt; 
	Usuarios de la aplicaci&oacute;n
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="95%"><h1>Usuarios en la aplicaci&oacute;n &quot;<?php echo $aplicacion->getNombre() ?>&quot;</h1></td>
		<td width="5%" align="right">
			<a href="#">
				<?php echo image_tag('pregunta.gif', array('alt' => 'Ayuda', 'id' => 'sprytrigger1', 'width' => '29', 'height' => '30', 'border' => '0')) ?>
			</a>
		</td>
	</tr>
</table>
<?php

/*
	$a = array();
	$q = Doctrine_Query::create();
	$q->select('rol_id')
		->from('AplicacionRol')
		->where('aplicacion_id = '.$id_aplicacion)
		->addWhere('deleted = 0');
	$roles = $q->execute();

//	foreach ($roles as $v_r) {
//		$q2 = Doctrine_Query::create();
//		$q2->select('usuario_id')
//		 	 ->from('UsuarioRol')
//		 	 ->where('rol_id = '.$v_r->getRolId())
//		 	 ->addWhere('deleted = 0');
//		$usuarios = $q2->execute();

	foreach ($roles as $v_r) {
		$q2 = Doctrine_Query::create();
		$q2->select('usuario_id')
		 	 ->from('UsuarioRol')
		 	 ->where('rol_id = '.$v_r->getRolId())
		 	 ->addWhere('deleted = 0');
		$usuarios = $q2->execute();
		
		foreach ($usuarios as $v_u) {
			$a[$v_u->getUsuarioId()] = $v_u->getUsuarioId();
//			$a[] = $v_u->getUsuarioId();
		}
	}
	echo '<pre>';
	print_r($a);
	echo '</pre>';
	echo count($a);
*/
	
?>