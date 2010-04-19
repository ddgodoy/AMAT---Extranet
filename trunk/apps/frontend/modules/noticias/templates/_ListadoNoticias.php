				<tr class="<?php echo $odd ?>">
				<td><?php if (validate_action('baja')): ?><input type="checkbox" name="id[]" value="<?php echo $noticia->getId() ?>" /><?php endif; ?></td>
				<td  width="11%" align="center"><span style="color:#999"><?php	echo date("d/m/Y", strtotime($noticia->getFecha()));?></span><br />
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
				</td>
				<td >
				<br clear="all">
				<a href="<?php echo url_for('noticias/show?id=' . $noticia->getId()) ?>"><strong><?php echo $noticia->getTitulo() ?></strong></a>
				<br clear="all">
				<br clear="all">
				<?php if ($noticia->getEntradilla()):?>
  			    <?php echo nl2br($noticia->getEntradilla())?>
				<?php endif; ?>
				</td>
				<td valign="center" align="center">
				<?php
					if ( validate_action('publicar') && $noticia->getEstado() != 'publicado' && $noticia->getEstado() != 'guardado') { 
						echo link_to(image_tag('publicar.png', array('border' => 0, 'title' => 'Publicar')), 'noticias/publicar?id=' . $noticia->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas publicar la noticia ' . $noticia->getTitulo() . '?'));
					}
					echo ($noticia->getEstado() == 'publicado')? image_tag('aceptada.png', array('border' => 0, 'title' => 'Publicado')): '';	
				?>
				</td>
				<td valign="center" align="center">
				<?php if (validate_action('modificar') || $creador == 1 && $noticia->getEstado() == 'guardado'):?>
				<a href="<?php echo url_for('noticias/editar?id='.$noticia->getId()) ?>"><?php echo image_tag('show.png', array('height' => 20, 'width' => 17, 'border' => 0, 'title' => 'Ver')) ?></a>
				<?php endif;?>
				</td>
				<td valign="center" align="center">
				<?php if(validate_action('baja') || $creador == 1 && $noticia->getEstado() == 'guardado'):?>
				<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'width' => '20', 'height' => '20', 'border' => '0')), 'noticias/delete?id='.$noticia->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar la noticia ' . $noticia->getTitulo() . '?')) ?>
			    <?php  endif;  ?>
			    </td>
				</tr>