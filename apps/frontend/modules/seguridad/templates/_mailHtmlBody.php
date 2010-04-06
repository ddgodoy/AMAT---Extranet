<html>
	<head>
		<title>Solicitud de Nueva Clave</title>
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
			height: 76px;
			margin-bottom: 5px;
		}
		-->
		</style>
	</head>
	<body>
		<div class="head"><img src="<?php echo $head_image ?>" alt=""></div>
		<table width="100%" border="0" cellpadding="0" cellspacing="5">
			<tr>
				<th align="left"><h1>Solicitud de Nueva Clave</h1></th>
			</tr>
			<tr>
				<td>
					Alguien ha solicitado una nueva clave para el usuario <strong><?php echo $login ?></strong>.<br />
					Para completar la solicitud visite este enlace: <br /><br />
					<a href="<?php echo $url ?>" style="color:#006699;font-weight:bold;" target="_blank">ACTIVAR NUEVA CLAVE</a><br /><br />
					En caso contrario, simplemente ignore este email.
				</td>
			</tr>
		</table>
	</body>
</html>