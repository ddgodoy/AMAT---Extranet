<html>
	<head>
	<title>Comunicado</title>
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
		<table width="100%" border="0" cellpadding="0" cellspacing="5">
                    <?php if($imagen):?>
                    <tr><td><img src="<?php echo "http://extranet.amat.es/uploads/tipo_comunicado/images/".$imagen ?>" alt=""></td></tr>
                    <?php endif;?>
	           <tr><td><?php echo $cuerpo ?></td></tr>
		</table>
	</body>
</html>