<tr class="<?php echo $odd ?>">
	<td><?php if (validate_action('publicar') && $evento->getEstado() == 'pendiente' || validate_action('baja')): ?><input type="checkbox" name="id[]" value="<?php echo $evento->getId() ?>" /><?php endif;?></td>
	<td  width="11%" align="center"><span style="color:#999"><?php	echo date("d/m/Y", strtotime($evento->getFecha()));?></span><br />
				<?php		
					if ($evento->getImagen()) {
						if(file_exists(sfConfig::get('sf_upload_dir').'/eventos/images/s_'.$evento->getImagen()))
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
	</td>
		<td><a href="<?php echo url_for('eventos/show?id=' . $evento->getId()) ?>"><strong><?php echo $evento->getTitulo() ?></strong></a></td>
		<td><?php echo $evento->getOrganizador() ?></td>
		<td><?php if (validate_action('publicar') || validate_action('modificar') || validate_action('alta') ){ 
                          if($evento->getAmbito()=='ambos')
                          { echo 'Extranet/Web';}
                          elseif($evento->getAmbito()=='intranet')
                          { echo 'Extranet';}
                          else{echo ucfirst($evento->getAmbito());}
                }?></td>
	<td><?php if (validate_action('publicar')):?><?php echo ucwords($evento->getEstado()) ?><?endif;?></td>
	<td>
	<?php if (validate_action('publicar') && $evento->getEstado() == 'pendiente'): ?>
		
			<?php echo link_to(image_tag('publicar.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')), 'eventos/publicar?id='.$evento->getId(), array('method' => 'post', 'confirm' => 'Est&aacute;s seguro que deseas publicar este evento?')) ?>

	<?php elseif ($evento->getEstado() == 'guardado'): ?>
		
			<a href="#" onclick="alert('Para publicar este evento es necesario que su estado esté en Pendiente')"><?php echo image_tag('publicar.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')) ?></a>
		
	<?php elseif (validate_action('publicar')): ?>
		
			<a href="#" onclick="alert('El evento ya ha sido publicado anteriormente')"><?php echo image_tag('aceptada.png', array('title' => 'Publicar', 'alt' => 'Publicar', 'border' => '0')) ?></a>
		
	<?php endif; ?>
	 </td> 
		<td>
		<?php if(validate_action('modificar') || $creador == 1 && $evento->getEstado() == 'guardado'):?>
			<a href="<?php echo url_for('eventos/editar?id=' . $evento->getId()) ?>"><?php echo image_tag('show.png', array('border' => 0, 'alt' => 'Editar', 'title' => 'Editar')) ?></a>
		<?php endif; ?>	
		</td>
	 <td>
	<?php if(validate_action('baja') || $creador == 1 && $evento->getEstado() == 'guardado'):?>
		<?php echo link_to(image_tag('borrar.png', array('title' => 'Borrar', 'alt' => 'Borrar', 'border' => '0')), 'eventos/delete?id='.$evento->getId(), array('method' => 'delete', 'confirm' => 'Est&aacute;s seguro que deseas eliminar el evento "' . $evento->getTitulo() . '"?')) ?>
	<?php endif; ?>	
	</td>
</tr>