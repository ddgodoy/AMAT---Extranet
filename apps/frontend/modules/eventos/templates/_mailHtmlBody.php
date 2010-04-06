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
		<div class="head" style="background-image: url('http://stageintranet.amat.es/images/mail_head.jpg'); height: 76px; margin-bottom: 5px;"></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="5" style="font-family: Verdana, Geneva, sans-serif; color: #333; font-size: 12px;">
			<tr>
				<th colspan="2" align="left"><h1 style="font-size: 16px; line-height: 30px; color: #006699; margin-left: 5px;"><?php echo $tema;?></h1></th>
			</tr>
			<tr>
				<td width="7%" style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;"><strong>T&iacute;tulo:</strong>&nbsp;</td>
				<td width="93%" style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;" ><a href="<?php echo $url ?>" style="color:#006699;font-weight:bold;" target="_blank"><?php echo $evento ?></a></td>
			</tr>
			<tr>
				<td style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;"><strong>Organiza:</strong>&nbsp;</td>
				<td style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;"><em><?php echo $organizador ?></em></td>
			</tr>
			<tr>
				<td valign="top" style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;" ><strong>Descripci&oacute;n:</strong>&nbsp;</td>
				<td style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;" ><?php echo nl2br($descripcio) ?></td>
			</tr>
			<tr>
				<td valign="top" style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;" >&nbsp;</td>
				<td style="border-top-width: 1px; border-top-style: dotted; border-top-color: #E1E1E1;padding: 5px;"><a href="<?php echo $url ?>" style="color:#09C;font-size:11px;" target="_blank">Ver m&aacute;s</a></td>
			</tr>
		</table>
	</body>
</html>