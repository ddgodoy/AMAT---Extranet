<tr >
<td width="11%" align="center"  style="border-bottom:1px dotted #999; padding:7px;"><div style="border-right:solid 1px #CCC"> <span style="color:#999"><?php	echo date("d/m/Y", strtotime($evento->getFecha()));?></span><br />
<?php		
	if ($evento->getImagen()) {
		if(file_exists(sfConfig::get('sf_upload_dir').'/noticias/images/s_'.$evento->getImagen()))
		{
			echo image_tag('/uploads/eventos/images/s_'.$evento->getImagen(), array('alt' => $evento->getTitulo()));
		}
		else 
		{
			echo image_tag('/uploads/eventos/images/'.$evento->getImagen(), array('height' => 60, 'width' => 80, 'alt' => $evento->getTitulo()));
		}
	}
	else {	
		echo image_tag('noimage.jpg', array('height' => 50, 'width' => 50, 'alt' => $evento->getTitulo()));
	}
 ?>
</div> 
</td>
<td width="88%" valign="top"  style="border-bottom:1px dotted #999; padding:7px;"><a href="<?php echo url_for('noticias/show?id=' . $evento->getId()) ?>"><strong><?php echo $evento->getTitulo() ?></strong></a> <br clear="all">
<?php if ($evento->getDescripcion()): echo nl2br($evento->getDescripcion()); endif; ?></td>
</tr>