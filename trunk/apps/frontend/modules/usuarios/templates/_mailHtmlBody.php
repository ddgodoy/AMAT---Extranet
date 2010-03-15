<html>
	<head>
		<title><?php echo 'Datos de accesos a Extranet de Asociados AMAT' ?></title>
	</head>
	<table>
	<tr>
		<td><strong><?php echo 'Datos del usuario: '.$apellido.', '.$nombre;?></strong><br /></td>
		</tr>
	    <tr>
		<td><strong>Usuario:</strong> <?php echo $login ?><br /></td>
		</tr>
	    <tr>
			<td><strong>Contraseña:</strong> <?php echo $password ?><br /></td>
		</tr>
		<tr>
		<td><strong>Para acceder a la Extranet de Asociados AMAT <a href="<?php  echo 'http://'.$host ?>">Click Aqu&iacute;</a></strong></td>
		</tr>
	</table>
</html>