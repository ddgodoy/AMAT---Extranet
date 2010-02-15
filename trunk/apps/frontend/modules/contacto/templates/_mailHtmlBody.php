<html>
	<head>
		<title><?php echo $tema ?></title>
	</head>
	<table>
	    <tr>
			<td><strong>Usuario:</strong> <?php echo $usuario ?><br /></td>
		</tr>
		<tr>
			<td><strong>Organización:</strong> <?php echo $organización ?><br /></td>
		</tr>
		<tr>
			<td><strong>Tema:</strong> <?php echo $tema ?><br /></td>
		</tr>
		<tr><td><strong>Asunto:</strong></td></tr>
		<tr>
			<td><?php echo nl2br($asunto) ?></td>
		</tr>
	</table>
</html>