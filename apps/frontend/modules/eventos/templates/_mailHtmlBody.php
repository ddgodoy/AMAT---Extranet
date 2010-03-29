<html>
	<head>
	<title><?php echo $evento ?></title>
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
				<th colspan="2" align="left"><h1><?php echo $tema;?></h1></th>
			</tr>
			<tr>
				<td width="7%"><strong>T&iacute;tulo:</strong>&nbsp;</td>
				<td width="93%"><a href="<?php echo $url ?>" style="color:#006699;font-weight:bold;" target="_blank"><?php echo $evento ?></a></td>
			</tr>
			<tr>
				<td><strong>Organiza:</strong>&nbsp;</td>
				<td><em><?php echo $organizador ?></em></td>
			</tr>
			<tr>
				<td valign="top"><strong>Descripci&oacute;n:</strong>&nbsp;</td>
				<td><?php echo nl2br($descripcio) ?></td>
			</tr>
			<tr>
				<td valign="top">&nbsp;</td>
				<td><a href="<?php echo $url ?>" style="color:#09C;font-size:11px;" target="_blank">Ver m&aacute;s</a></td>
			</tr>
		</table>
	</body>
</html>