<tr >
<td width="11%" align="center"  style="border-bottom:1px dotted #999; padding:7px;"><div style="border-right:solid 1px #CCC"> <span style="color:#999"><?php	echo date("d/m/Y", strtotime($noticia->getFecha()));?></span><br />
<?php		
	if ($noticia->getImagen()) {
		if(file_exists(sfConfig::get('sf_upload_dir').'/noticias/images/s_'.$noticia->getImagen()))
		{
			echo image_tag('/uploads/noticias/images/s_'.$noticia->getImagen(), array('alt' => $noticia->getTitulo()));
		}
		else 
		{
			echo image_tag('/uploads/noticias/images/'.$noticia->getImagen(), array('height' => 60, 'width' => 80, 'alt' => $noticia->getTitulo()));
		}
	}
	else {	
		echo image_tag('noimage.jpg', array('height' => 50, 'width' => 50, 'alt' => $noticia->getTitulo()));
	}
 ?>
</div> 
</td>
<td width="88%" valign="top"  style="border-bottom:1px dotted #999; padding:7px;"><a href="<?php echo url_for('noticias/show?id=' . $noticia->getId()) ?>"><strong><?php echo $noticia->getTitulo() ?></strong></a> <br clear="all">
<?php if ($noticia->getEntradilla()): echo nl2br($noticia->getEntradilla()); endif; ?></td>
</tr>