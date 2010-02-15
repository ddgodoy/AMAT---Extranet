<html>
	<head>
		<title><?php echo 'Evento: '.$evento ?></title>
	</head>
	<table>
	<tr>
		<td><strong><?php echo $tema;?></strong><br /></td>
		</tr>
	    <tr>
		<td><strong>Titulo:</strong> <?php echo $evento ?><br /></td>
		</tr>
	    <tr>
			<td><strong>Organiza:</strong> <?php echo $organizador ?><br /></td>
		</tr>
		<tr>
		<td><strong>Descripcion:</strong></td>
		</tr>
		<tr>
	    <td><?php echo nl2br($descripcio) ?></td>
		</tr>
	</table>
</html>