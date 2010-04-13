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
<td width="88%" valign="top" colspan="3"  style="border-bottom:1px dotted #999; padding:7px;"><a href="<?php echo url_for('noticias/show?id=' . $noticia->getId()) ?>"><strong><?php echo $noticia->getTitulo() ?></strong></a> <br clear="all">
<?php if ($noticia->getEntradilla()): echo nl2br($noticia->getEntradilla()); endif; ?></td>
<td valign="center" align="center" style="border-bottom:1px dotted #999; padding:7px;">
<?php if (validate_action('modificar') || $creador == 1):?>
<a href="<?php echo url_for('noticias/editar?id='.$noticia->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?></a>
<?php endif;?>
</td>
<td valign="center" align="center" style="border-bottom:1px dotted #999; padding:7px;">
<?php if(validate_action('baja') || $creador == 1):?>
<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'noticias/delete?id='.$noticia->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la noticia ' . $noticia->getTitulo() . '?')) ?>
<?php  endif;  ?>
</td>
</tr>