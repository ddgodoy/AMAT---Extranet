<html>
	<head>
	<title>Datos de accesos a Extranet de Asociados AMAT</title>
	<style type="text/css">
		<!--
		table {
			font-family: Verdana, Geneva, sans-serif;
			color: #333;
			font-size: 12px;
		}
		body table tr td {
			border-top-width: 1px;
			border-top-style: dotted;
			border-top-color: #E1E1E1;
			padding: 5px;
		}
		body table tr th h1 {
			font-size: 16px;
			line-height: 30px;
			color: #006699;
			margin-left: 5px;
		}
		.head {
			background-image: url(<?php echo $head_image ?>);
			height: 76px;
			margin-bottom: 5px;
		}
		-->
	</style>
	</head>
	<body>
		<div class="head"></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="5">
			<tr>
				<th colspan="2" align="left"><h1><?php echo 'Datos del usuario: '.$apellido.', '.$nombre;?></h1></th>
			</tr>
			<tr>
				<td width="7%"><strong>Usuario:</strong>&nbsp;</td>
				<td width="93%"><?php echo $login ?></td>
			</tr>
			<tr>
				<td><strong>Contrase&ntilde;a:</strong>&nbsp;</td>
				<td><em><?php echo $password ?></em></td>
			</tr>
			<tr>
				<td colspan="2">
					Para acceder a la Extranet de Asociados AMAT <a href="<?php  echo 'http://'.$host ?>" target="_blank">Click Aqu&iacute;</a>
				</td>
			</tr>
		</table>
	</body>
</html>