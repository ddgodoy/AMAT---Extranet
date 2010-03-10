<h1>
	Novedades<span class="der"><a href="<?php echo url_for('noticias/index') ?>">Ver m&aacute;s Noticia</a></span>
</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="listados herramientas" style="border:none;">
	<?php $i=0; foreach ($ultimas_noticias as $noticia): $odd = fmod(++$i, 2) ? 'blanco' : 'gris' ?>
	<tr class="<?php echo $odd ?>">
		<td align="center" valign="top">
			<?php if ($noticia->getImagen()): ?>
				<img src="<?php echo '/uploads/noticias/images/s_'.$noticia->getImagen() ?>" width="50" height="50" alt="Noticias" />
			<?php endif; ?>
		</td>
		<td valign="top">
			<a href="<?php echo url_for('noticias/show?id='.$noticia->getId()) ?>">
				<strong><?php echo stripslashes($noticia->getTitulo()) ?></strong>
			</a>
			<?php echo date("d/m/Y", strtotime($noticia->getFecha())) ?><br />
			<p><?php echo $noticia->getEntradilla() ?></p>
		</td>
	</tr>
<?php endforeach; ?>
</table>